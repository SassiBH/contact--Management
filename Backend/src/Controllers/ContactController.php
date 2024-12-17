<?php
namespace App\Controllers;

use App\Models\Contact;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;


class ContactController
{
    //Extracting the contact list for the authentified user
    public function index()
    {
        $userId = $this->getUserIdFromToken(); 

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $contacts = Contact::find($userId);

        if ($contacts) {
            echo json_encode($contacts);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No contacts found for this user']);
        }
    }


//Adding new contact

    public function store($data)
    {
        if(!($data['user_id'])){
            $data['user_id']= $this->getUserIdFromToken();
        }
        if (Contact::create($data)) {
            echo json_encode(['message' => 'Contact created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Unable to create contact']);
        }
    }

//Update a contact

    public function update($id, $data)
    {
         // Log the received data
         error_log("Updating contact with ID: $id and data: " . json_encode($data));

         if (Contact::update($id, $data)) {
             echo json_encode(['message' => 'Contact updated successfully']);
         } else {
             http_response_code(404);
             echo json_encode(['error' => 'Contact not found']);
         }
    }

//Delete a contact    

    public function destroy($id)
    {
        if (Contact::delete($id)) {
            echo json_encode(['message' => 'Contact deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Unable to delete contact']);
        }
    }

//Extract user ID from the JWT token

    private function getUserIdFromToken(): ?int
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return null;
        }

        $jwt = $matches[1];
        try {
            // Decode and validate the JWT
            $decoded = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS256'));

            // Ensure `$decoded` is treated as an object
            if (is_object($decoded) && property_exists($decoded, 'sub')) {
                return (int)$decoded->sub; // Extract `sub` claim as user ID
            }

            return null;
        } catch (Exception $e) {
            error_log('JWT decode error: ' . $e->getMessage());
            return null;
        }
    }

//Filter the user list

    public function search()
    {
        $query = $_GET['query'] ?? '';
        if (empty($query)) {
            http_response_code();
            echo json_encode(['error' => 'Search query is required']);
            return;
        }

        $userId = $this->getUserIdFromToken();
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        // Proceed to search contacts for the authenticated user
        $results = Contact::search($query, $userId);
        echo json_encode($results);
    }
    
}
