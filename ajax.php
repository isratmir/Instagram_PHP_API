<?php

	require "instagram.class.php";
	
	$instagram = new Instagram('client_id');
	
	$tag = $_GET['tag'];
	$maxID = $_GET['max_id'];
	$clientID = $instagram->getApiKey();
	
	//$call = new stdClass;
	//$call->pagination->next_max_id=$maxID;
	//$call->pagination->next_url="https://api.instagram.com/v1/tags/{$tag}/media/recent?client_id={$clientID}&max_tag_id={$maxID}";
	
	$media = $instagram->getTagMedia('cola',$auth=false,array('max_tag_id'=>$maxID));
	
	$images = array();
	$dt = array();
	foreach($media->data as $data){
		$dt[] = $data;
	}
	//die(print_r($dt));
	echo json_encode(array(
		'next_id'=>$media->pagination->next_max_id,
		'dt' =>$dt
	));
	
	