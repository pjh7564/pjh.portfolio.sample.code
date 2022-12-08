<?php
	include "../common/config.php";
	include "../common/function.php";  

	try {

		$PROJECT_TITLE = rtnShowTextBr($_POST['PROJECT_TITLE']);
		$EXECUTIVE_BUDGET = rtnShowTextBr($_POST['EXECUTIVE_BUDGET']);
		$CAMPAIGN_PERIOD = rtnShowTextBr($_POST['CAMPAIGN_PERIOD']);
		$OFFER_DEADLINE = rtnShowTextBr($_POST['OFFER_DEADLINE']);
		$SELECTION_DEADLINE = rtnShowTextBr($_POST['SELECTION_DEADLINE']);
		$ADDITIONAL_INFORMATION = rtnShowTextBr($_POST['ADDITIONAL_INFORMATION']);
		$MEETING_WHETHER = rtnShowTextBr($_POST['MEETING_WHETHER']);
		$PROJECT_CODE = rtnShowTextBr($_POST['PROJECT_CODE']);

		if ($PROJECT_CODE == "") {
			// 새 프로젝트 코드 생성
			$NEW_PROJECT_CODE = 'PJ_'.generateRandomString(5).date("His",time());

			// 지원자 코드 생성
			$APPLY_CODE = 'AP_'.generateRandomString(5).date("His",time());

			//관심분야 코드
			$INTERESTS_CODE = 'IC_'.generateRandomString(5).date("His",time());

			$PROJECT_STATUS = '신규등록';
		} else {
			$query="SELECT * FROM `ai_project` WHERE `PROJECT_CODE` = '".$PROJECT_CODE."'";
			$result=mysqli_query($db_connect, $query)or die(mysqli_error());
			$data=mysqli_fetch_array($result);
			extract($data);

			if ($data) {
				$OLD_APPLY_CODE = $data['APPLY_CODE'];
				$OLD_INTERESTS_CODE = $data['INTERESTS_CODE'];
				$OLD_PROJECT_CODE = $data['PROJECT_CODE'];
			}

			$NEW_PROJECT_TITLE = rtnShowTextBr($_POST['PROJECT_TITLE']);
			$NEW_EXECUTIVE_BUDGET = rtnShowTextBr($_POST['EXECUTIVE_BUDGET']);
			$NEW_CAMPAIGN_PERIOD = rtnShowTextBr($_POST['CAMPAIGN_PERIOD']);
			$NEW_OFFER_DEADLINE = rtnShowTextBr($_POST['OFFER_DEADLINE']);
			$NEW_SELECTION_DEADLINE = rtnShowTextBr($_POST['SELECTION_DEADLINE']);
			$NEW_ADDITIONAL_INFORMATION = rtnShowTextBr($_POST['ADDITIONAL_INFORMATION']);
			$NEW_MEETING_WHETHER = rtnShowTextBr($_POST['MEETING_WHETHER']);
		}

		

		//프로젝트 업로드 파일
		if($_FILES["UPLOAD_FILE"]['size'] == 0) {
			$NEW_UPLOAD_FILE = "";
		} else {
			$uploaddir = '../uploads/member/'.$PROJECT_TITLE.'/';

			$ext = end(explode(".",strtolower($_FILES["UPLOAD_FILE"]["name"])));

			$changeName = $PROJECT_TITLE.'_PROJECT.'.$ext ;
			$NEW_UPLOAD_FILE = $changeName;

			if (!file_exists($uploaddir)) {
				mkdir($uploaddir, 0777, true);
			}

			if($_FILES["UPLOAD_FILE"]["size"][$i] > (10*1024*1024)){
				throw new Exception('size error', $_FILES["UPLOAD_FILE"]["size"]);
				echo "<script>alert('파일 용량이 너무 큽니다!!');history.back();</script>";
				exit;
			}

			//확장자제한
			$arr_ext = array("exe","dll");
			if (in_array($ext,$arr_ext)) { 
				echo "<script>alert('업로드가 불가능한 파일종류입니다.');history.back();</script>";
				exit;
			}

			move_uploaded_file($_FILES['UPLOAD_FILE']['tmp_name'], $uploaddir . $changeName);
		}

		//프로젝트 분류
		$INTERESTS_CHECK = rtnShowTextBr($_POST['INTERESTS_CHECK']);

		$PROJECT_RESULT = '진행';

		//등록시간
		$REGISTRATION_DATE = date("Y-m-d H:i:s",time());
		//수정시간
		$MODIFIED_DATE = date("Y-m-d H:i:s",time());
		
		if(!$INTERESTS_CHECK) {
			$INTERESTS_CHECK = "";
		} else {
			$INTERESTS_ARRAY = explode(",", $INTERESTS_CHECK);

			foreach($INTERESTS_ARRAY as $KEY=>$DATA){

				switch ($DATA) {
				case 'SEARCH_ADS':
					$SEARCH_ADS = "checked";
					break;
				case 'SEARCH_OPTIMIZATION':
					$SEARCH_OPTIMIZATION = "checked";
					break;
				case 'RETARGETING':
					$RETARGETING = "checked";
					break;
				case 'MOBILE_AD':
					$MOBILE_AD = "checked";
					break;
				case 'BANNER_AD':
					$BANNER_AD = "checked";
					break;
				case 'BLOG_MARKETING':
					$BLOG_MARKETING = "checked";
					break;
				case 'OPEN_MARKET':
					$OPEN_MARKET = "checked";
					break;
				case 'PRESS_PUBLICITY':
					$PRESS_PUBLICITY = "checked";
					break;
				case 'YOUTUBE':
					$YOUTUBE = "checked";
					break;
				case 'INSTAGRAM':
					$INSTAGRAM = "checked";
					break;
				case 'INFLUENCER':
					$INFLUENCER = "checked";
					break;
				case 'CAFE_MARKETING':
					$CAFE_MARKETING = "checked";
					break;
				case 'ONLINE_INTEGRATED_MARKETING':
					$ONLINE_INTEGRATED_MARKETING = "checked";
					break;
				case 'FACEBOOK':
					$FACEBOOK = "checked";
					break;
				case 'CPA':
					$CPA = "checked";
					break;
				case 'CPI':
					$CPI = "checked";
					break;
				case 'ONLINE_OTHER':
					$ONLINE_OTHER = "checked";
					break;
				case 'RADIO_AD':
					$RADIO_AD = "checked";
				case 'BUS_AD':
					$BUS_AD = "checked";
					break;
				case 'FACILITY_AD':
					$FACILITY_AD = "checked";
					break;
				case 'PAPER_AD':
					$PAPER_AD = "checked";
					break;
				case 'OUTDOOR_AD':
					$OUTDOOR_AD = "checked";
					break;
				case 'SUBWAY_AD':
					$SUBWAY_AD = "checked";
					break;
				case 'OFFLINE_INTEGRATED_MARKETING':
					$OFFLINE_INTEGRATED_MARKETING = "checked";
					break;
				case 'IPTV':
					$IPTV = "checked";
					break;
				case 'OFFLINE_OTHER':
					$OFFLINE_OTHER = "checked";
					break;
				case 'CORPORATE_EVENT_PLANNING':
					$CORPORATE_EVENT_PLANNING = "checked";
					break;
				case 'EXHIBITION_PLANNING':
					$EXHIBITION_PLANNING = "checked";
					break;
				case 'PROMOTION_PLANNING':
					$PROMOTION_PLANNING = "checked";
					break;
				case 'PLANNING_OTHER':
					$PLANNING_OTHER = "checked";
					break;
				case 'VIDEO_PRODUCTION':
					$VIDEO_PRODUCTION = "checked";
					break;
				case 'PPL':
					$PPL = "checked";
					break;
				case 'PRODUCTION_OTHER':
					$PRODUCTION_OTHER = "checked";
					break;
				}
			}

			if ($OLD_PROJECT_CODE) {
				//파트너 관심분야 업데이트
				$query2="UPDATE `ai_member_interests` 
				SET `SEARCH_ADS`='$SEARCH_ADS', 
				`SEARCH_OPTIMIZATION`='$SEARCH_OPTIMIZATION', 
				`RETARGETING`='$RETARGETING', 
				`MOBILE_AD`='$MOBILE_AD', 
				`BANNER_AD`='$BANNER_AD', 
				`BLOG_MARKETING`='$BLOG_MARKETING', 
				`OPEN_MARKET`='$OPEN_MARKET', 
				`PRESS_PUBLICITY`='$PRESS_PUBLICITY', 
				`YOUTUBE`='$YOUTUBE', 
				`INSTAGRAM`='$INSTAGRAM', 
				`INFLUENCER`='$INFLUENCER', 
				`CAFE_MARKETING`='$CAFE_MARKETING', 
				`ONLINE_INTEGRATED_MARKETING`='$ONLINE_INTEGRATED_MARKETING', 
				`FACEBOOK`='$FACEBOOK', 
				`CPA`='$CPA', 
				`CPI`='$CPI', 
				`ONLINE_OTHER`='$ONLINE_OTHER', 
				`RADIO_AD`='$RADIO_AD', 
				`BUS_AD`='$BUS_AD', 
				`FACILITY_AD`='$FACILITY_AD', 
				`PAPER_AD`='$PAPER_AD', 
				`OUTDOOR_AD`='$OUTDOOR_AD', 
				`SUBWAY_AD`='$SUBWAY_AD', 
				`OFFLINE_INTEGRATED_MARKETING`='$OFFLINE_INTEGRATED_MARKETING', 
				`IPTV`='$IPTV', 
				`OFFLINE_OTHER`='$OFFLINE_OTHER', 
				`CORPORATE_EVENT_PLANNING`='$CORPORATE_EVENT_PLANNING', 
				`EXHIBITION_PLANNING`='$EXHIBITION_PLANNING', 
				`PROMOTION_PLANNING`='$PROMOTION_PLANNING', 
				`PLANNING_OTHER`='$PLANNING_OTHER', 
				`VIDEO_PRODUCTION`='$VIDEO_PRODUCTION', 
				`PPL`='$PPL', 
				`PRODUCTION_OTHER`='$PRODUCTION_OTHER', 
				`MODIFIED_DATE`='$MODIFIED_DATE' 
				WHERE `INTERESTS_CODE` = '".$OLD_INTERESTS_CODE."'";
			} else {
				//프로젝트 관심분야생성
				$query2="INSERT INTO `ai_member_interests` (`INTERESTS_CODE`, `SEARCH_ADS`, `SEARCH_OPTIMIZATION`, `RETARGETING`, `MOBILE_AD`, `BANNER_AD`, `BLOG_MARKETING`, `OPEN_MARKET`, `PRESS_PUBLICITY`, `YOUTUBE`, `INSTAGRAM`, `INFLUENCER`,`CAFE_MARKETING`,`ONLINE_INTEGRATED_MARKETING`,`FACEBOOK`,`CPA`,`CPI`,`ONLINE_OTHER`,`RADIO_AD`,`BUS_AD`,`FACILITY_AD`,`PAPER_AD`,`OUTDOOR_AD`,`SUBWAY_AD`,`OFFLINE_INTEGRATED_MARKETING`,`IPTV`,`OFFLINE_OTHER`,`CORPORATE_EVENT_PLANNING`,`EXHIBITION_PLANNING`,`PROMOTION_PLANNING`,`PLANNING_OTHER`,`VIDEO_PRODUCTION`,`PPL`,`PRODUCTION_OTHER`, `REGISTRATION_DATE`, `MODIFIED_DATE`)
				VALUES ('$INTERESTS_CODE', '$SEARCH_ADS', '$SEARCH_OPTIMIZATION', '$RETARGETING', '$MOBILE_AD', '$BANNER_AD', '$BLOG_MARKETING', '$OPEN_MARKET', '$PRESS_PUBLICITY', '$YOUTUBE', '$INSTAGRAM', '$INFLUENCER','$CAFE_MARKETING', '$ONLINE_INTEGRATED_MARKETING', '$FACEBOOK', '$CPA', '$CPI', '$ONLINE_OTHER', '$RADIO_AD', '$BUS_AD', '$FACILITY_AD', '$PAPER_AD', '$OUTDOOR_AD', '$SUBWAY_AD', '$OFFLINE_INTEGRATED_MARKETING', '$IPTV', '$OFFLINE_OTHER', '$CORPORATE_EVENT_PLANNING', '$EXHIBITION_PLANNING', '$PROMOTION_PLANNING', '$PLANNING_OTHER','$VIDEO_PRODUCTION', '$PPL', '$PRODUCTION_OTHER', '$REGISTRATION_DATE', '$MODIFIED_DATE')";
			}

			$result2=mysqli_query($db_connect, $query2)or die(mysqli_error());
			$data2=mysqli_fetch_array($result2);
			extract($data2);
		}

		if ($OLD_PROJECT_CODE) {
			//기존 프로젝트 수정
			$query="UPDATE `ai_project` 
			SET `INTERESTS_CODE`='$OLD_INTERESTS_CODE', 
			`PROJECT_TITLE`='$NEW_PROJECT_TITLE', 
			`EXECUTIVE_BUDGET`='$NEW_EXECUTIVE_BUDGET', 
			`CAMPAIGN_PERIOD`='$NEW_CAMPAIGN_PERIOD', 
			`OFFER_DEADLINE`='$NEW_OFFER_DEADLINE', 
			`SELECTION_DEADLINE`='$NEW_SELECTION_DEADLINE', 
			`ADDITIONAL_INFORMATION`='$NEW_ADDITIONAL_INFORMATION', 
			`FILE_UPLOAD`='$NEW_UPLOAD_FILE', 
			`MEETING_WHETHER`='$NEW_MEETING_WHETHER', 
			`MODIFIED_DATE`='$MODIFIED_DATE' 
			WHERE `PROJECT_CODE` = '".$OLD_PROJECT_CODE."'";
		} else {
			// 새 프로젝트 생성
			$query="INSERT INTO `ai_project` (`MEMBER_CODE`, `APPLY_CODE`, `PROJECT_CODE`, `INTERESTS_CODE`, `PROJECT_TITLE`, `EXECUTIVE_BUDGET`, `CAMPAIGN_PERIOD`, `OFFER_DEADLINE`, `SELECTION_DEADLINE`, `ADDITIONAL_INFORMATION`, `FILE_UPLOAD`, `MEETING_WHETHER`, `PROJECT_RESULT`, `PROJECT_STATUS`, `REGISTRATION_DATE`, `MODIFIED_DATE` )
			VALUES ('$ai_mc', '$APPLY_CODE', '$NEW_PROJECT_CODE', '$INTERESTS_CODE', '$PROJECT_TITLE', '$EXECUTIVE_BUDGET', '$CAMPAIGN_PERIOD', '$OFFER_DEADLINE', '$SELECTION_DEADLINE', '$ADDITIONAL_INFORMATION', '$NEW_UPLOAD_FILE', '$MEETING_WHETHER', '$PROJECT_RESULT', '$PROJECT_STATUS', '$REGISTRATION_DATE', '$MODIFIED_DATE')";
		}
		
		$result=mysqli_query($db_connect, $query)or die(mysqli_error());
		$data=mysqli_fetch_array($result);
		extract($data);

		//배열생성 및 초기화
		$resultArray = array('PROJECT_CODE'=>'', 'RESULT'=>'OK');

		if ($OLD_PROJECT_CODE) {
			//배열에 리턴시킬 결과 데이터를 셋팅
			$resultArray['PROJECT_CODE'] = $OLD_PROJECT_CODE;
		} else {
			//배열에 리턴시킬 결과 데이터를 셋팅
			$resultArray['PROJECT_CODE'] = $NEW_PROJECT_CODE;
		}

		print json_encode($resultArray);
		
	} catch(exception $e) {
		echo 'ERROR';
		exit;
	}
?>
