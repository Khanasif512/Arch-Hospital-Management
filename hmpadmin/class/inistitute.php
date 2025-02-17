<?php 
/*include '../connect.php';*/
/**
 * 
 */

class Innistitute{ 

    public function todayPendingFollowup($today){       
        return $result = QB::query("SELECT * FROM witty_client_req_tbl WHERE next_followup_date = '{$today}' ORDER BY id DESC LIMIT 30 ")->get();
    }

    public function todayPendingFollowup_count($today){       
        return $result = QB::query("SELECT COUNT(id) as num FROM witty_client_req_tbl WHERE next_followup_date = '{$today}'  ")->first();
    }

      public function todayContactFollowup($today){       
        return $result = QB::query("SELECT * FROM witty_client_req_tbl WHERE last_followup_date = '{$today}' ORDER BY id DESC LIMIT 30 ")->get();
    }

    public function todayContactFollowup_count($today){       
        return $result = QB::query("SELECT COUNT(id) as num FROM witty_client_req_tbl WHERE last_followup_date = '{$today}'  ")->first();
    }


    public function countInistComment($today){  
       return $result = QB::query("SELECT COUNT(id) as totalComnt, COUNT(DISTINCT(witty_req_id)) as uniqueID  FROM witty_comments WHERE Date(rem_date) = '{$today}' ")->first();

   }

   public function witty_todays_deliveredSms($today){       
        return $result = QB::query("SELECT COUNT(t1.id) as num, SUM(t1.qty) AS totalQty, COUNT(DISTINCT t1.uhid) AS totalInst FROM sms_history t1 
                         INNER JOIN witty_client_req_tbl t2 ON t2.id=t1.uhid AND t1.type=1 WHERE DATE(t1.date) = '{$today}'")->first();
    }

      public function witty_todays_sentEmail($today){       
        return $result = QB::query("SELECT COUNT(camp_email_set_request.id) as num, COUNT(DISTINCT camp_email_set_request.req_id) as uniqueRequest FROM camp_email_set_request  
                        INNER JOIN camp_email_set ON camp_email_set_request.set_id=camp_email_set.id
                        INNER JOIN camp_email_template ON camp_email_template.id=camp_email_set.temp_id
                        INNER JOIN witty_client_req_tbl ON witty_client_req_tbl.id=camp_email_set_request.req_id WHERE DATE(camp_email_set.time) = '{$today}' ")->first();
    }
}