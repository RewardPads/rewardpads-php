<?php


class RewardPadsAPI {
        private $api_key;
        private $api_secret;
        private $base_url = 'http://rest.rewardpads.com';

        function RewardPadsAPI($key,$secret){
                $this->api_key = $key;
                $this->api_secret = $secret;
        }

        function listCustomers($customer_id=null){
                if(!is_null($customer_id)){
                        return $this->curl('/customers/'.$customer_id);
                } else {
                        return $this->curl('/customers');
                }
        }

        function addCustomer($info){
                $vars = array('name','website','venue_type','signup_date','corporate_name');
                $data = array();
                foreach($vars as $v){
                        if(isset($info[$v])){
                                $data[$v] = $info[$v];
                        }
                }
                return $this->curl('/customers','POST',$data);
        }

        function listCustomerStores($customer_id){
                return $this->curl('/customers/'.$customer_id.'/stores');
        }

        function updateCustomer($customer_id, $updates){
                $vars = array('name','venue_type','website','signup_date','corporate_name');
                $data = array();
                foreach($vars as $v){
                        if(isset($updates[$v])){
                                $data[$v] = $updates[$v];
                        }
                }
                $this->curl('/customers/'.$customer_id,'PUT',$data);
        }

        function deleteCustomer($customer_id){
                return $this->curl('/customers/'.$customer_id,'DELETE');
        }

        function deleteStore($store_id){
                return $this->curl('/stores/'.$store_id, 'DELETE');
        }

        function deleteUser($user_id){
                return $this->curl('/users/'.$user_id, 'DELETE');
        }


        function listStores($store_id=null){
                if(!is_null($store_id)){
                        return $this->curl('/stores/'.$store_id);
                } else {
                        return $this->curl('/stores');
                }
        }

        function addStore($info){
                $vars = array('customer_id','description','status','billing_line1','billing_line2','address_line1','address_line2','city','state','zip','latitude','longitude','facebook_id','plan_id','bill_method','sms_keyword','shortcode','phone','corporate_id');
                $data = array();
                foreach($vars as $v){
                        if(isset($info[$v])){
                                $data[$v] = $info[$v];
                        }
                }
                return $this->curl('/stores','POST',$data);
        }


        function updateStore($store_id, $updates){
                return $this->curl('/stores/'.$store_id,'PUT',$updates);
        }

        function listPatrons($store_id = null){
                if(!is_null($store_id)){
                        return $this->curl('/stores/'.$store_id.'/patrons');
                } else {
                        return $this->curl('/patrons');
                }
        }
        function searchPatrons($search){
                return $this->curl('/patrons/search','POST', $search);
        }

        function listCampaigns($type=null){
                if(!is_null($type)){
                        return $this->curl('/campaigns/'.$type.'.json');
                } else {
                        return $this->curl('/campaigns.json');
                }
        }

        function listAnnouncements(){
                return $this->curl('/announcements');
        }

        function acknowledgeAnnouncement($data){
                return $this->curl('/announcements/acknowledge','POST',$data);
        }
        function acceptAnnouncement($data){
                return $this->curl('/announcements/accept','POST',$data);
        }
        function declineAnnouncement($data){
                return $this->curl('/announcements/decline','POST',$data);
        }

        function addCampaign($info){
                $vars = array('store_id','coupon_type','coupon_description','issue_code','issue_date','expire_date');
                $data = array();
                foreach($vars as $v){
                        if(isset($info[$v])){
                                $data[$v] = $info[$v];
                        }
                }
                return $this->curl('/campaigns.json','POST',$data);
        }

        function listKiosks($store_id=null){
                if(!is_null($store_id)){
                        return $this->curl('/stores/'.$store_id.'/kiosks');
                } else {
                        return $this->curl('/kiosks');
                }
        }

        function listCustomerUsers($customer_id){
                return $this->curl('/customers/'.$customer_id.'/users');
        }


        function listStoreUsers($store_id){
                return $this->curl('/stores/'.$store_id.'/users');
        }

        function addUser($info){
                return $this->curl('/users','POST',$info);
        }

        function getUser($user_id){
                return $this->curl('/users/'.$user_id);
        }

        function updateUser($user_id,$data){
                $vars = array('customer_id','store_id','username','password','display_name','phone','admin');
                $updates = array();
                foreach($vars as $v){
                        if(isset($data[$v])){
                                $updates[$v] = $data[$v];
                        }
                }
                return $this->curl('/users/'.$user_id,'PUT',$updates);

        }



        function dailyStoreVisits($store_id, $options = array() ){
                if(count($options) > 0){
                        return $this->curl('/stores/'.$store_id.'/visits/daily','POST', $options);
                } else {
                        return $this->curl('/stores/'.$store_id.'/visits/daily');
                }
        }


        function getTheme($theme_id){
                return $this->curl('/themes/'.$theme_id);
        }

        function listThemes(){
                return $this->curl('/themes');
        }



        function listInvoices(){
                return $this->curl('/invoices');
        }
        function listStoreInvoices($store_id){
                return $this->curl('/stores/'.$store_id.'/invoices');
        }
        function getInvoice($invoice_id){
                return $this->curl('/invoices/'.$invoice_id);
        }

        function listPlans($plan_id=null){
                if(!is_null($plan_id)){
                        return $this->curl('/plans/'.$plan_id);
                } else {
                        return $this->curl('/plans');
                }
        }
        function updatePlan($plan_id, $updates = array()){
                $vars = array('plan_description','total_sms','price');
                $data = array();
                foreach($vars as $v){
                        if(isset($updates[$v])){
                                $data[$v] = $updates[$v];
                        }
                }
                $this->curl('/plans/'.$plan_id,'PUT',$data);

        }
        function deletePlan($plan_id){
                return $this->curl('/plans/'.$plan_id, 'DELETE');
        }
        function addPlan($info){
                $vars = array('plan_type','plan_description','total_sms','price');
                $data = array();
                foreach($vars as $v){
                        if(isset($info[$v])){
                                $data[$v] = $info[$v];
                        }
                }
                return $this->curl('/plans','POST',$data);
        }

        private function curl($url,$method = 'GET',$data = array()){
                $cmd = "/usr/bin/curl -s -H 'Accept: application/json' -X $method '{$this->base_url}{$url}' -u {$this->api_key}:{$this->api_secret}";
                foreach($data as $key => $val){
                        $val = urlencode($val);
                        $cmd .= " -d '{$key}={$val}'";
                }
                error_log("HOSTED CURL: $cmd");
                exec($cmd, $json_response, $return_var);
                return json_decode(join('',$json_response));
        }

}
