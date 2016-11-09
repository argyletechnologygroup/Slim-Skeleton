<?php 

namespace App\Utils;

///Class to retrieve google sheet CSV lead data
class GoogleSheetCsvRetriever {
    
    //LeadCsvParser
    private $parser;
    
    //Google drive service
    private $driveService;
    
    private $c;
    
    ///Constructor which takes a Util\LeadCsvParser
    public function __construct(ICsvParser $parser, \Google_Service_Drive $driveService, \Slim\Container $container) {
       $this->parser = $parser;
       //TODO insantiate $driveService
       $this->driveService = $driveService;
       $this->c = $container;
   }
   
    ///Method to retrieve google sheet CSV
    public function downloadCSV($fileId){
        try{
            $response = $this->driveService->files->export($fileId, 'text/csv', ['alt'=>'media']);
            //$response = $this->api($fileId, 'GET', ['alt'=>'media
            $content = $response->getBody()->getContents();
            $contentExport = var_export($content, 1);
            $this->c->get('logger')->debug("Retrieved Google content for file {$fileId}: {$content}");
            return $this->parser->parse( $content );
        } catch (\Google_Service_Exception $e) {
            $this->c->get('logger')->warning("Google service exception for file {$fileId} Caught exception:[{$e->getCode()}] {$e->getMessage()}\n{$e->getTrace()}");
        }
        return false;
    }
    
    private function api( $file_id, $method = "GET", $parameters = array(), $decode_json = true){
        $url = "https://www.googleapis.com/drive/v3/files/{$file_id}?alt=media";
        $adapter = $this->c->get('google_hybrid_adapter');
        $response = $adapter->api( $url, $method, $parameters, $decode_json);
        $this->c->get('logger')->debug("Response retrieved from Google for file {$file_id} \n".var_export($response,1));
		if (isset($response->error)) {
            $err = "Drive file request failed! {$adapter->id} returned an invalid response:" . \Hybrid_Logger::dumpData( $response );
            $this->c->get('logger')->error($err);
			throw new \Exception($err, 6);
		}
        return $response;
    }
}
