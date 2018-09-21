<?php

use Slim\Http\Request;
use Slim\Http\Response;

$auth = function ($request, $response, $next) {
    
    $key = $request->getQueryParam("key");

    if(!isset($key)){
        return $response->withJson(["status" => "API Key required"], 401);
    }
    
    $sql = "SELECT * FROM api_users WHERE api_key=:api_key";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":api_key" => $key]);
    
    if($stmt->rowCount() > 0){
        $result = $stmt->fetch();
        if($key == $result["api_key"]){
        
            // update hit
            $sql = "UPDATE api_users SET hit=hit+1 WHERE api_key=:api_key";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":api_key" => $key]);
            
            return $response = $next($request, $response);
        }
    }

    return $response->withJson(["status" => "Unauthorized"], 401);
};

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// RESTful api
// generate apikey `echo bin2hex(random_bytes(20))`;
// $app->group("/api/", function($req, $res, $args){
$app->group('/api', function () use ($app) {
	$app->get("/telepon/", function (Request $request, Response $response, $args){
	    $sql = "SELECT * FROM telepon";
	    $stmt = $this->db->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->fetchAll();
	    return $response->withJson(["status" => "success", "data" => $result], 200);
	});

	$app->get("/telepon/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $sql = "SELECT * FROM telepon WHERE id=:id";
	    $stmt = $this->db->prepare($sql);
	    $stmt->execute([":id" => $id]);
	    $result = $stmt->fetch();
	    return $response->withJson(["status" => "success", "data" => $result], 200);
	});

	$app->get("/telepon/search/", function (Request $request, Response $response, $args){
	    $keyword = $request->getQueryParam("keyword");
	    $sql = "SELECT * FROM telepon WHERE nama LIKE '%$keyword%' OR telepon LIKE '%$keyword%'";
	    $stmt = $this->db->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->fetchAll();
	    return $response->withJson(["status" => "success", "data" => $result], 200);
	});

	$app->post("/telepon/", function (Request $request, Response $response){

	    $new_book = $request->getParsedBody();

	    $sql = "INSERT INTO telepon (nama, nomor) VALUE (:nama, nomor)";
	    $stmt = $this->db->prepare($sql);

	    $data = [
	        ":nama" => $new_book["nama"],
	        ":nomoer" => $new_book["nomor"]
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

	$app->put("/telepon/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $new_book = $request->getParsedBody();
	    $sql = "UPDATE telepon SET nama=:nama, nomor=:nomor WHERE id=:id";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	        ":id" => $id,
	        ":nama" => $new_book["nama"],
	        ":nomor" => $new_book["nomor"]
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

	$app->delete("/telepon/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $sql = "DELETE FROM telepon WHERE id=:id";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	        ":id" => $id
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

})->add($auth);