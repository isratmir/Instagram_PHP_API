<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Instagram more button example</title>
  <meta name="author" content="Christian Metz">
  <!--
    Instagram PHP API class @ Github
    https://github.com/cosenary/Instagram-PHP-API
  -->
  <style>
    article, aside, figure, footer, header, hgroup, 
    menu, nav, section { display: block; }
    ul {
      width: 1260px;
    }
    ul > li {
      float: left;
      list-style: none;
      padding: 4px;
    }
    #more {
      bottom: 8px;
      margin-left: 80px;
      position: fixed;
      font-size: 13px;
      font-weight: 700;
      line-height: 20px;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<link rel="stylesheet" href="/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<script type="text/javascript" src="/source/jquery.fancybox.pack.js?v=2.1.4"></script>

  <script>
    $(document).ready(function() {
			$('ul li a').fancybox();
      $('#more').click(function() {
        var tag   = $(this).data('tag'),
            maxid = $(this).data('maxid');
        
        $.ajax({
          type: 'GET',
          url: 'ajax.php',
          data: {
            tag: tag,
            max_id: maxid
          },
          dataType: 'json',
          cache: false,
          success: function(data) {
            // Output data
            $.each(data.dt, function(i) {
              $('ul#photos').append('<li><a href="'+data.dt[i].images.standard_resolution.url+'" title="'+data.dt[i].caption.text+'"><img src="' + data.dt[i].images.low_resolution.url + '"></a><br><span>Likes: '+data.dt[i].likes.count+' | Comments: '+data.dt[i].comments.count+'</span></li>');
            });
            
            // Store new maxid
            $('#more').data('maxid', data.next_id);
          }
        });
      });
    });
  </script>
</head>
<body>
 
<?php
  
  require_once 'instagram.class.php';
 
  $instagram = new Instagram('client_id');
	$tag="cola";
  $media = $instagram->getTagMedia($tag);
	
	 
  echo "<ul id=\"photos\">";
  foreach ($media->data as $data) {
    echo "<li><a href=\"{$data->images->standard_resolution->url}\" title=\"{$data->caption->text}\"><img src=\"{$data->images->low_resolution->url}\"></a><br><span>Likes: {$data->likes->count} | Comments: {$data->comments->count}</span></li>";
  }
  echo "</ul>";
 
  echo "<br><button id=\"more\" data-maxid=\"{$media->pagination->next_max_id}\" data-tag=\"{$tag}\">Load more ...</button>";
 
?>
 
</body>
</html>