<?php

	/**
	* @param CSV path $path
	* @return 2D array of all CSV data
	*/
	function getArrayOfData($path)
	{
		$file = file($path);
		foreach($file as $i)
			$csv[]=explode(',',$i);
		
		return $csv;
	}
	
	/**
	* @return array of all dates a month before fresher's week
	*/
	function getActiveDates()
	{
		$array = array();
		$period = new DatePeriod(
			new DateTime('2020-08-15'),
			new DateInterval('P1D'),
			new DateTime('2020-09-15')
		);
		
		foreach ($period as $key => $value) {
			array_push($array, $value->format('d/m/Y'));
		}
		
		return $array;
	}
	
	/**
	* Creates lists for each property manager and appointments to be rescheduled by passing the date and times of an appointment through
	* various conditions and comparisons.
	*
	* Compares if times one the same date are within 2 hours of each other
	* Moves these times to second manager, compares if the second manager already has an appointment wiithin two hours on that date
	* Moves to the third and repeats comparison of time on date
	* Flagged to be rescheduled
	*
	* Appointments on last day of month flagged for reschedule
	*
	* @param CSV array $csvData
	* @param date array $dateArray
	* @return 3D array of all manager and reschedule appointments
	*/
	function sortTenantAppointments($csvData, $dateArray)
	{
		$tenantID = 0;
		$firstName = 1;
		$surname = 2;
		$email = 3;
		$date = 4;
		$time = 5;
		$propertyID = 6;
		
		$firstManagerArray = array();
		$secondManagerArray = array();
		$thirdManagerArray = array();
		$rescheduleArray = array();
		
		$finalArray = array();
		
		for($d=0; $d < count($dateArray); $d++){
			for($i=1; $i < count($csvData); $i++){
				if($csvData[$i][$date] == $dateArray[$d]){
					if($dateArray[$d] == "31/08/2020"){
						$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
						array_push($rescheduleArray, $toAdd);
					}else{
						if($i == 1){
							$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
							array_push($firstManagerArray, $toAdd);
						}else{
							$prevTime = (new DateTime(date("G:i", strtotime($csvData[$i-1][$time]))))->modify('+2 hours');
							$currentTime = new DateTime(date("G:i", strtotime($csvData[$i][$time])));
							if($csvData[$i][$time] == $csvData[$i-1][$time] && $csvData[$i][$propertyID] == $csvData[$i-1][$propertyID]){
								$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
								array_push($firstManagerArray, $toAdd);
							}else if($prevTime > $currentTime && $csvData[$i][$propertyID] != $csvData[$i-1][$propertyID]){
								if($csvData[$i][$date] == $csvData[$i-1][$date]){
									if(count($secondManagerArray) == 0){
										$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
										array_push($secondManagerArray, $toAdd);
									}else{
										$count2 = count($secondManagerArray);
										$prevTime2 = (new DateTime(date("G:i", strtotime($secondManagerArray[$count2-1][$time]))))->modify('+2 hours');
										$currentTime2 = new DateTime(date("G:i", strtotime($csvData[$i][$time])));
										if($prevTime2 > $currentTime2 && $csvData[$i][$propertyID] == $secondManagerArray[$count2-1][$propertyID]){
											$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
											array_push($secondManagerArray, $toAdd);
										}else if($prevTime2 > $currentTime2 && $csvData[$i][$propertyID] != $secondManagerArray[$count2-1][$propertyID] && $csvData[$i][$date] != $secondManagerArray[$count2-1][$date]){
											$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
											array_push($secondManagerArray, $toAdd);
										}else if($prevTime2 > $currentTime2 && $csvData[$i][$propertyID] != $secondManagerArray[$count2-1][$propertyID] && $csvData[$i][$date] == $secondManagerArray[$count2-1][$date]){
											if(count($thirdManagerArray) == 0){
												$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
												array_push($thirdManagerArray, $toAdd);
											}else{
												$count3 = count($thirdManagerArray);
												$prevTime3 = (new DateTime(date("G:i", strtotime($thirdManagerArray[$count3-1][$time]))))->modify('+2 hours');
												$currentTime3 = new DateTime(date("G:i", strtotime($csvData[$i][$time])));
												if($prevTime3 > $currentTime3 && $csvData[$i][$propertyID] == $thirdManagerArray[$count3-1][$propertyID]){
													$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
													array_push($thirdManagerArray, $toAdd);
												}else if($prevTime3 > $currentTime3 && $csvData[$i][$propertyID] != $thirdManagerArray[$count3-1][$propertyID] && $csvData[$i][$date] != $thirdManagerArray[$count3-1][$date]){
													$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
													array_push($thirdManagerArray, $toAdd);
												}else if($prevTime3 > $currentTime3&& $csvData[$i][$propertyID] != $thirdManagerArray[$count3-1][$propertyID] && $csvData[$i][$date] == $thirdManagerArray[$count3-1][$date]){
													$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
													array_push($rescheduleArray, $toAdd);
												}else{
													$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
													array_push($thirdManagerArray, $toAdd);
												}
											}
										}else{
											$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
											array_push($secondManagerArray, $toAdd);
										}
									}
								}else{
									$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
									array_push($firstManagerArray, $toAdd);
								}
							}else{
								$toAdd = array($csvData[$i][$tenantID],$csvData[$i][$firstName],$csvData[$i][$surname],$csvData[$i][$email],$csvData[$i][$date],$csvData[$i][$time],$csvData[$i][$propertyID]);
								array_push($firstManagerArray, $toAdd);
							}
						}
					}
				}
			}
		}
		
		array_push($finalArray, $firstManagerArray);
		array_push($finalArray, $secondManagerArray);
		array_push($finalArray, $thirdManagerArray);
		array_push($finalArray, $rescheduleArray);
		
		return $finalArray;
	}
?>
