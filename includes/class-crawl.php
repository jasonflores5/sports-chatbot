<? /***** Crawl Function *****/

//Crawl
class DialogFlowCrawl {

	//User-input text
	public function set_filtered_input_text($input_text) {

		$this->filtered_input_text = str_replace(" ", "+", $input_text);

	}

	public function get_input_text() {
		return $this->filtered_input_text;
	}

	public function set_dialogflow_url() {

		$this->url = 'https://api.dialogflow.com/v1/query?v=20150910&lang=en&query='. $this->filtered_input_text .'&sessionId=12345&timezone=America/Los_Angeles';

	}

	//Single-threaded Crawl
	public function set_file_contents_curl() {
	    $this->authorization_token='[ENTER_DIALOGFLOW_AUTH_TOKEN]';

	    $ch = curl_init();
		
		$header = array();
		$header[] = 'Authorization: Bearer '. $this->authorization_token;

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $this->crawl_data = curl_exec($ch);
	    curl_close($ch);
	    
	}

	public function get_file_contents_curl() {
		return $this->crawl_data;
	}

	public function get_json_decode() {
		return json_decode($this->crawl_data, true);
	}

}

?>