<?php
include_once('includes/config.php');
/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$studie = new Studie();

switch($method) {
    case 'GET':
        // Kontrollera om det är något ID medskickat
        if(isset($id)) {
            // Om ett ID är medskickat, hämta enbart ut data från detta ID
            $response = $studie->getStudieById($id);
        } else {
            //Skickar en "HTTP response status code"
            http_response_code(200); //Ok - The request has succeeded
            // Om inget ID är med skickat, hämta ut alla kurser
            $response = $studie->getStudies();
        }
        if(count($response) == 0) {
            //Lagrar ett meddelande som sedan skickas tillbaka till anroparen
            http_response_code(404); // Not found
            $response = array("message" => "No studie found");
        }

        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));
        
        if($studie->addStudie($data->uni, $data->edu, $data->start, $data->end)) {
            $response = array("message" => "Created");

            http_response_code(201); //Created
            
        } else {
            $response = array("message" => "Something went wrong");
            http_response_code(500); // Server error
        }
        
        
        break;
    case 'PUT':
        //Om inget id är med skickat, skicka felmeddelande
        if(!isset($id)) {
            http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id is sent");
        //Om id är skickad   
        } else {
            $data = json_decode(file_get_contents("php://input"));

            if($studie->updateStudie($id, $data->uni, $data->edu, $data->start, $data->end)) {
                $response = array("message" => "Updated");

                http_response_code(200);
                $response = array("message" => "Post with id=$id is updated");
            } else {
                $response = array("message" => "Something went wrong");
                }    
            }
        break;
    case 'DELETE':
        if(!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");  
        } else {
            if($studie->deleteStudie($id)) {
                http_response_code(200);
                $response = array("message" => "Post with id=$id is deleted");
            } else {
                $response = array("message" => "Something went wrong..");
            }
        }
        break;
        
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);