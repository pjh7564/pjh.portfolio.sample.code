<?php 
	include('./header.php');
	include('./client_user_check.php');

	$PROJECT_CODE = $_GET['PROJECT_CODE'];

	$query="SELECT * FROM `ai_project` WHERE `MEMBER_CODE` = '".$ai_mc."' AND `PROJECT_CODE` = '".$PROJECT_CODE."'";
	$result=mysqli_query($db_connect, $query)or die(mysqli_error());
	$data=mysqli_fetch_array($result);
	extract($data);

	if($data) {
		$PJ_MEMBER_CODE = $data['MEMBER_CODE'];
		$PJ_INTERESTS_CODE = $data['INTERESTS_CODE'];
		
		$query2="SELECT * FROM `ai_member` WHERE `MEMBER_CODE` = '".$PJ_MEMBER_CODE."'";
		$result2=mysqli_query($db_connect, $query2)or die(mysqli_error());
		$data2=mysqli_fetch_array($result2);
		extract($data2);

		if($data2) {
			$PJ_NAME = $data2['NAME'];
			$PJ_CONTACT_INFORMATION = $data2['CONTACT_INFORMATION'];
			$PJ_INDUSTRY = $data2['INDUSTRY'];
			$PJ_EMAIL = $data2['EMAIL'];
			$PJ_COMPANY_ADRESS = $data2['COMPANY_ADRESS'];
			$PJ_HOME_PAGE = $data2['HOME_PAGE'];
		}

		$query3="SELECT * FROM `ai_member_interests` WHERE `INTERESTS_CODE` = '".$PJ_INTERESTS_CODE."'";
		$result3=mysqli_query($db_connect, $query3)or die(mysqli_error());
		$data3=mysqli_fetch_array($result3);
		extract($data3);
	}
?>
		<div id="container">
			<div class="search_tit upload_tit">
				<div class="wrapper">
					<strong>광고장터에 프로젝트를 등록해보세요.</strong>
				</div>
			</div>
			<div class="upload_wrap">
				<div class="wrapper">
					<div class="border top">
						<strong class="up_tit">클라이언트 정보</strong>
						<p class="thumb"><img src="../images/ico/ico_sub_my02.jpg" alt=""></p>
						<table class="pro_table">
							<caption>클라이언트 정보</caption>
							<colgroup>
								<col width="133px">
								<col width="330px">
								<col width="145px">
							</colgroup>
							<tbody>
								<tr>
									<th>담당자 이름</th>
									<td>
										<?php if ($PJ_MEMBER_CODE) { ?>
											<?=$PJ_NAME?>
										<?php } else { ?>
											<?=$NAME?>
										<?php } ?>
									</td>
									<th>담당자 연락처</th>
									<td>
										<?php if ($PJ_CONTACT_INFORMATION) { ?>
											<?=$PJ_CONTACT_INFORMATION?>
										<?php } else { ?>
											<?=$CONTACT_INFORMATION?>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<th>업종</th>
									<td>
										<?php if ($PJ_INDUSTRY) { ?>
											<?=$PJ_INDUSTRY?>
										<?php } else { ?>
											<?=$INDUSTRY?>
										<?php } ?>
									</td>
									<th>담당자 이메일</th>
									<td>
										<?php if ($PJ_EMAIL) { ?>
											<?=$PJ_EMAIL?>
										<?php } else { ?>
											<?=$EMAIL?>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<th>주소</th>
									<td>
										<?php if ($PJ_COMPANY_ADRESS) { ?>
											<?=$PJ_COMPANY_ADRESS?>
										<?php } else { ?>
											<?=$COMPANY_ADRESS?>
										<?php } ?>
									</td>
									<th>홈페이지</th>
									<td>
										<?php if ($PJ_HOME_PAGE) { ?>
											<?=$PJ_HOME_PAGE?>
										<?php } else { ?>
											<?=$HOME_PAGE?>
										<?php } ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<form method="post" action="project_upload_action.php" id="upLoadForm" name="upLoadForm" onsubmit="return FormCheck()" enctype="multipart/form-data">
						<input type="hidden" id="INTERESTS_CHECK" name="INTERESTS_CHECK" />
						<input type="hidden" id="PROJECT_CODE" name="PROJECT_CODE" value="<?=$PROJECT_CODE?>">
						<div class="border check">
							<strong class="up_tit">필수입력사항</strong>
							<p class="small_tit"><span>프로젝트 분류</span></p>
							<span>온라인 광고</span>
							<ul class="checkbox_wrap">
								<li>
									<label for="SEARCH_ADS"><input type="checkbox" name="ONLINE" id="SEARCH_ADS" value1="검색광고" value2="SEARCH_ADS" <?=$data3['SEARCH_ADS']?>><i></i><span>검색광고</span></label>
									<label for="SEARCH_OPTIMIZATION"><input type="checkbox" name="ONLINE" id="SEARCH_OPTIMIZATION" value1="검색 최적화" value2="SEARCH_OPTIMIZATION" <?=$data3['SEARCH_OPTIMIZATION']?>><i></i><span>검색 최적화</span></label>
									<label for="RETARGETING"><input type="checkbox" name="ONLINE" id="RETARGETING" value1="리타겟팅" value2="RETARGETING" <?=$data3['RETARGETING']?>><i></i><span>리타겟팅</span></label>
									<label for="MOBILE_AD"><input type="checkbox" name="ONLINE" id="MOBILE_AD" value1="모바일광고" value2="MOBILE_AD" <?=$data3['MOBILE_AD']?>><i></i><span>모바일광고</span></label>
									<label for="BANNER_AD"><input type="checkbox" name="ONLINE" id="BANNER_AD" value1="배너광고" value2="BANNER_AD" <?=$data3['BANNER_AD']?>><i></i><span>배너광고</span></label>
									<label for="BLOG_MARKETING"><input type="checkbox" name="ONLINE" id="BLOG_MARKETING" value1="블로그마케팅" value2="BLOG_MARKETING" <?=$data3['BLOG_MARKETING']?>><i></i><span>블로그마케팅</span></label>
									<label for="OPEN_MARKET" class="store"><input type="checkbox" name="ONLINE" id="OPEN_MARKET" value1="스토어팜/오픈마켓" value2="OPEN_MARKET" <?=$data3['OPEN_MARKET']?>><i></i><span>스토어팜/오픈마켓</span></label>
									<label for="PRESS_PUBLICITY"><input type="checkbox" name="ONLINE" id="PRESS_PUBLICITY" value1="언론홍보" value2="PRESS_PUBLICITY" <?=$data3['PRESS_PUBLICITY']?>><i></i><span>언론홍보</span></label>
									<label for="YOUTUBE"><input type="checkbox" name="ONLINE" id="YOUTUBE" value1="유튜브" value2="YOUTUBE" <?=$data3['YOUTUBE']?>><i></i><span>유튜브</span></label>
								</li>
								<li>
									<label for="INSTAGRAM"><input type="checkbox" name="ONLINE" id="INSTAGRAM" value1="인스타그램" value2="INSTAGRAM" <?=$data3['INSTAGRAM']?>><i></i><span>인스타그램</span></label>
									<label for="INFLUENCER"><input type="checkbox" name="ONLINE" id="INFLUENCER" value1="인플루언서" value2="INFLUENCER" <?=$data3['INFLUENCER']?>><i></i><span>인플루언서</span></label>
									<label for="CAFE_MARKETING"><input type="checkbox" name="ONLINE" id="CAFE_MARKETING" value1="카페마케팅" value2="CAFE_MARKETING" <?=$data3['CAFE_MARKETING']?>><i></i><span>카페마케팅</span></label>
									<label for="ONLINE_INTEGRATED_MARKETING"><input type="checkbox" name="ONLINE" id="ONLINE_INTEGRATED_MARKETING" value1="통합마케팅" value2="ONLINE_INTEGRATED_MARKETING" <?=$data3['ONLINE_INTEGRATED_MARKETING']?>><i></i><span>통합마케팅</span></label>
									<label for="FACEBOOK"><input type="checkbox" name="ONLINE" id="FACEBOOK" value1="페이스북" value2="FACEBOOK" <?=$data3['FACEBOOK']?>><i></i><span>페이스북</span></label>
									<label for="CPA"><input type="checkbox" name="ONLINE" id="CPA" value1="CPA" value2="CPA" <?=$data3['CPA']?>><i></i><span>CPA</span></label>
									<label for="CPI" class="store"><input type="checkbox" name="ONLINE" id="CPI" value1="CIP/앱마케팅" value2="CPI" <?=$data3['CPI']?>><i></i><span>CIP/앱마케팅</span></label>
									<label for="ONLINE_OTHER"><input type="checkbox" name="ONLINE" id="ONLINE_OTHER" value1="기타" value2="ONLINE_OTHER" <?=$data3['ONLINE_OTHER']?>><i></i><span>기타</span></label>
								</li>
							</ul>
							<span>오프라인 광고</span>
							<ul class="checkbox_wrap">
								<li>
									<label for="RADIO_AD"><input type="checkbox" name="OFFLINE" id="RADIO_AD" value1="라디오광고" value2="RADIO_AD" <?=$data3['RADIO_AD']?>><i></i><span>라디오광고</span></label>
									<label for="BUS_AD"><input type="checkbox" name="OFFLINE" id="BUS_AD" value1="버스광고" value2="BUS_AD" <?=$data3['BUS_AD']?>><i></i><span>버스광고</span></label>
									<label for="FACILITY_AD"><input type="checkbox" name="OFFLINE" id="FACILITY_AD" value1="시설광고" value2="FACILITY_AD" <?=$data3['FACILITY_AD']?>><i></i><span>시설광고</span></label>
									<label for="PAPER_AD"><input type="checkbox" name="OFFLINE" id="PAPER_AD" value1="지면광고" value2="PAPER_AD" <?=$data3['PAPER_AD']?>><i></i><span>지면광고</span></label>
									<label for="OUTDOOR_AD"><input type="checkbox" name="OFFLINE" id="OUTDOOR_AD" value1="옥외광고" value2="OUTDOOR_AD" <?=$data3['OUTDOOR_AD']?>><i></i><span>옥외광고</span></label>
									<label for="SUBWAY_AD"><input type="checkbox" name="OFFLINE" id="SUBWAY_AD" value1="지하철광고" value2="SUBWAY_AD" <?=$data3['SUBWAY_AD']?>><i></i><span>지하철광고</span></label>
									<label for="OFFLINE_INTEGRATED_MARKETING" class="store"><input type="checkbox" name="OFFLINE" id="OFFLINE_INTEGRATED_MARKETING" value1="통합마케팅" value2="OFFLINE_INTEGRATED_MARKETING" <?=$data3['OFFLINE_INTEGRATED_MARKETING']?>><i></i><span>통합마케팅</span></label>
									<label for="IPTV"><input type="checkbox" name="OFFLINE" id="IPTV" value1="TV/IPTV광고" value2="IPTV" <?=$data3['IPTV']?>><i></i><span>TV/IPTV광고</span></label>
									<label for="OFFLINE_OTHER"><input type="checkbox" name="OFFLINE" id="OFFLINE_OTHER" value1="기타" value2="OFFLINE_OTHER" <?=$data3['OFFLINE_OTHER']?>><i></i><span>기타</span></label>
								</li>
							</ul>
							<span>행사/프로모션</span>
							<ul class="checkbox_wrap">
								<li>
									<label for="CORPORATE_EVENT_PLANNING" class="store"><input type="checkbox" name="PROMOTION" id="CORPORATE_EVENT_PLANNING" value1="기업행사 기획/대행" value2="CORPORATE_EVENT_PLANNING" <?=$data3['CORPORATE_EVENT_PLANNING']?>><i></i><span>기업행사 기획/대행</span></label>
									<label for="EXHIBITION_PLANNING"><input type="checkbox" name="PROMOTION" id="EXHIBITION_PLANNING" value1="박람회 기획/대행" value2="EXHIBITION_PLANNING" <?=$data3['EXHIBITION_PLANNING']?>><i></i><span>박람회 기획/대행</span></label>
									<label for="PROMOTION_PLANNING" class="store"><input type="checkbox" name="PROMOTION" id="PROMOTION_PLANNING" value1="프로모션 기획/대행" value2="PROMOTION_PLANNING" <?=$data3['PROMOTION_PLANNING']?>><i></i><span>프로모션 기획/대행</span></label>
									<label for="PLANNING_OTHER"><input type="checkbox" name="PROMOTION" id="PLANNING_OTHER" value1="기타" value2="PLANNING_OTHER" <?=$data3['PLANNING_OTHER']?>><i></i><span>기타</span></label>
								</li>
							</ul>
							<span>영상제작/PPL</span>
							<ul class="checkbox_wrap">
								<li>
									<label for="VIDEO_PRODUCTION" class="store"><input type="checkbox" name="VIDEOPPL" id="VIDEO_PRODUCTION" value1="영상제작" value2="VIDEO_PRODUCTION" <?=$data3['VIDEO_PRODUCTION']?>><i></i><span>영상제작</span></label>
									<label for="PPL"><input type="checkbox" name="VIDEOPPL" id="PPL" value1="PPL" value2="PPL" <?=$data3['PPL']?>><i></i><span>PPL</span></label>
									<label for="PRODUCTION_OTHER"><input type="checkbox" name="VIDEOPPL" id="PRODUCTION_OTHER" value1="기타" value2="PRODUCTION_OTHER" <?=$data3['PRODUCTION_OTHER']?>><i></i><span>기타</span></label>
								</li>
							</ul>
							<div class="my_right my_edit myinfo">
								<div class="border">
									<div class="charge info_txt">
										<strong><label for="up_entry01">프로젝트 제목</label></strong>
										<div class="ch_input">
											<input type="text" id="up_entry01" name="PROJECT_TITLE" placeholder="브랜드인지도/ 유입/ 전환성과/ 홍보/ CPA 등" value='<?=$data['PROJECT_TITLE']?>'/>
											<em>프로젝트 목적은 필수입니다.</em><!--활성화시 태그 추가-->
										</div>
										<strong><label for="up_entry02">집행예산</label></strong>
										<div class="ch_input">
											<input type="text" id="up_entry02" name="EXECUTIVE_BUDGET" placeholder="ex)3000" value="<?=$data['EXECUTIVE_BUDGET']?>"><span>만원</span>
											<em>집행 예산은 필수입니다.</em><!--활성화시 태그 추가-->
										</div>
										<strong><label for="up_entry03">캠페인 기간</label></strong>
										<div class="ch_input">
											<input type="text" id="up_entry03" name="CAMPAIGN_PERIOD" placeholder="ex)3" value="<?=$data['CAMPAIGN_PERIOD']?>"><span>개월</span>
											<em>캠페인 기간은 필수입니다.</em><!--활성화시 태그 추가-->
										</div>
										<strong><label for="up_entry04">제안 마감일</label></strong>
										<div class="ch_input">
											<input type="text" id="up_entry04" name="OFFER_DEADLINE" placeholder="YYYY-MM-DD" value="<?=$data['OFFER_DEADLINE']?>">
											<em>제안 마감일은 필수입니다.</em><!--활성화시 태그 추가-->
										</div>
										<strong><label for="up_entry05">선정 마감일</label></strong>
										<div class="ch_input">
											<input type="text" id="up_entry05" name="SELECTION_DEADLINE" placeholder="YYYY-MM-DD" value="<?=$data['SELECTION_DEADLINE']?>">
											<em>선정 마감일은 필수입니다.</em><!--활성화시 태그 추가-->
										</div>
										<strong><label for="up_entry06">추가정보입력</label></strong>
										<div class="ch_input ch_last">
											<textarea style="width:440px" id="ADDITIONAL_INFORMATION" name="ADDITIONAL_INFORMATION"><?=$data['ADDITIONAL_INFORMATION']?></textarea>
											<!-- <input type="text" id="up_entry06" id="ADDITIONAL_INFORMATION" name="ADDITIONAL_INFORMATION" placeholder="추가정보를 입력해주세요."> -->
										</div>
										<strong><label for="up_entry07">파일 업로드</label></strong>
										<div class="file">
											<input type="text" class="upload_file" id="up_entry07" placeholder="파일을 업로드해주세요." value="<?=$data['FILE_UPLOAD']?>" disabled="disabled">
											<label for="UPLOAD_FILE">파일 선택</label>
											<input type="file" id="UPLOAD_FILE" name="UPLOAD_FILE" class="upload_hidden">
											<p><em>20MB이하</em></p>
										</div>
										<div class="checkbox_wrap meet_ch">
											<label for="MEETING_WHETHER">
												<span>미팅 필요시 체크</span>
												<input type="checkbox" id="MEETING_WHETHER" name="MEETING_WHETHER" value="checked" <?=$data['MEETING_WHETHER']?>>
												<i></i>
											</label>
										</div>
										<div class="edit_btn">
											<input type="button" class="complete" onclick="uploadCheck();" value="프로젝트 등록하기">
										</div>
									</div>
								</div>
							</div>	
						</div>
					</form>
				</div>				
			</div>		
		</div>
		<!-- <div id="plus_infopop" class="popup_wrap">
			<div class="popup">
				<div class="pop_con">
					<strong class="text_tit">추가정보입력</strong>
					<div class="info_text">
						<textarea></textarea>
						<p>내용을 작성해주세요.<br>
							<em>＊ 고객님의 연락처 / 이메일을 입력하시면 문의전화가 많이 올 수 있어, 기입을 권장드리지 않습니다.</em>
						</p>
					</div>
					<div class="edit_btn">
						<input type="submit" class="complete" value="확인">
						<a href="#;" class="cancel pop_close">취소</a>
					</div>
				</div>
				<a href="#;" class="pop_close close">닫기</a>
			</div>
		</div> -->
		<script type="text/javascript">
			$(document).on("click", "input:checkbox", function(e) {
				var checkedId_arr = [];
				var code = $("input[name='INTERESTS_CHECK']");
				
				var onlineChecked = $("input[name='ONLINE']:checked");
				$(onlineChecked).each(function() {
					checkedId_arr.push($(this).attr("value2"));
				});

				var offlineChecked = $("input[name='OFFLINE']:checked");
				$(offlineChecked).each(function() {
					checkedId_arr.push($(this).attr("value2"));
				});
				

				var promotionChecked = $("input[name=PROMOTION]:checked");
				$(promotionChecked).each(function() {
					checkedId_arr.push($(this).attr("value2"));
				});
				
				var videopplChecked = $("input[name=VIDEOPPL]:checked");
				$(videopplChecked).each(function() {
					checkedId_arr.push($(this).attr("value2"));
				});

				code.val(checkedId_arr);
			});
			// $( document ).ready( function() {
			// 	$("input:text").on("propertychange change keyup paste input", function() {
			// 		alert(this.value);
			// 	});
			// });


			// 수정완료
			function uploadCheck(){

				var obj = document.upLoadForm;
				
				if(obj.PROJECT_TITLE.value == "") {
					alert("프로젝트 제목을 입력하세요");
					setTimeout(function(){
						obj.PROJECT_TITLE.focus();
						return false;
					}, 1);
				} else if(obj.EXECUTIVE_BUDGET.value == "") {
					alert("집행예산을 입력하세요");
					setTimeout(function(){
						obj.EXECUTIVE_BUDGET.focus();
						return false;
					}, 1);
				} else if(obj.CAMPAIGN_PERIOD.value == "") {
					alert("캠페인기간을 입력하세요");
					setTimeout(function(){
						obj.CAMPAIGN_PERIOD.focus();
						return false;
					}, 1);
				} else if(obj.OFFER_DEADLINE.value == "") {
					alert("제안 마감일을 입력하세요");
					setTimeout(function(){
						obj.OFFER_DEADLINE.focus();
						return false;
					}, 1);
				} else if(obj.SELECTION_DEADLINE.value == "") {
					alert("선정 마감일을 입력하세요");
					setTimeout(function(){
						obj.SELECTION_DEADLINE.focus();
						return false;
					}, 1);
				} else if(obj.INTERESTS_CHECK.value == "") {
					alert("프로젝트 분류를 선택하세요");
					return false;
				} else {
					var form = $('#upLoadForm')[0];
					var data = new FormData(form);

					$.ajax({
						type: "POST",
						url: "./project_upload_action.php",
						dataType: "json",
						enctype: 'multipart/form-data',
						processData: false,
						contentType: false,
						data : data,
						success : function(data) {
							var obj2 = JSON.stringify(data);
            				var obj = JSON.parse(obj2);

							location.replace(`./project_upload_ok.php?PROJECT_CODE=${obj.PROJECT_CODE}`);
						},
						error: function (request, status, error) {
							console.log("code: " + request.status);
							console.log("message: " + request.responseText);
							console.log("error: " + error);
						}
					})
				}
			}
		</script>
<?php 
	include('./footer.php');
?>
