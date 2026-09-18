<?php



/**
 * Handles form submissions
 */
class submissionHandling {
    
    const sandbox = FALSE;

    public function getRecaptchaKeys(){
        return get_field('recaptcha_keys','options');
    } 

    public function getUsefulData($post) {

        $removeKeys = array(
            'action',
            'table_name'
        );

        foreach($removeKeys as $key) {
            unset($post[$key]);
        }

       return $post;
    }

    public function storeSubmission() {
        
    
        // Get and sanitize all post data
        $post = array_map("strip_tags",$_POST);

        $usefulData = (new submissionHandling)->getUsefulData($post);

        // rp_suite__create_new_table($post['table_name'],$usefulData);

        // rp_suite__update_table($post['table_name'],$usefulData);

        submissionHandling::submitEmail($usefulData);
        
    
    }

    static private function submitEmail($data)
    {
        
         // Build POST request:
         $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
         $recaptcha_secret = RECAPT_SECRET;
         $recaptcha_response = $_POST['g-recaptcha-response'];

         // Make and decode POST request:
         $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
         $recaptcha = json_decode($recaptcha);

         $recaptcha_score = $recaptcha->score ?? 'n/a';

         $recaptcha_error = ''; 

         // Take action based on the score returned:
         if ($recaptcha->score >= 0.7) {
           

                // Set myMailJet() options
                $from = 'from@website.com';
                $to = 'to@website.com';
                $subject = 'Demo';
                $message    = 'A message';
                $textpart = $message;
        
                $from 		= 	array(
                    'email'		=>	$from,
                    'name'		=>	'Demo site'
                );
        
                $to 		= 	array(
                    'email'		=>	$to,
                    'name'		=>	'Demo site'
                );

        
                // Initiate class
                $mailjet = new myMailJet();

                
                
                // Call pub function on class, send email - also returns status ( success, error etc)
                $status = $mailjet->sendEmail($message, $from, $to, $subject, $textpart);

                // var_dump($status);

            } else {

                // If error codes exist,  return them to store in db
                if(is_array($recaptcha->{'error-codes'})){
                    $recaptcha_error =  'Error codes:';
                    $recaptcha_error .= $recaptcha->{'error-codes'}[0];
                    $recaptcha_score = $recaptcha_score . ' - ' . $recaptcha_error;
                }

                $status = 'recaptcha fail';
                
                
            }
    
    }

}


  
add_action( 'admin_post_nopriv_catch_submission', array('submissionHandling','storeSubmission') );
add_action( 'admin_post_catch_submission', array('submissionHandling','storeSubmission') );