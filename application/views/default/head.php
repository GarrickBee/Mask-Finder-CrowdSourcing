<?php defined('BASEPATH') or die('Unauthorized Access'); ?>
<head>
	<!-- Primary Meta Tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo empty($head['title'])?"Mask Finder":$head['title'];?></title>
	<meta name="title" content="<?php echo empty($head['title'])?"Mask Finder":$head['title'];?>">
	<meta name="description" content="<?php echo empty($head['description'])?"Join the biggest community and help others to fight Corona Virus together! Let others know by sharing your latest surgical mask bought location through our mask finder. ":$head['description'];?>">
	<meta name="author" content="Garrick Ng,<?php echo empty($head['author'])?"ndf_724@hotmail.com":$head['author'];?>" />
	<meta name="designer" content="Garrick Ng">
	<meta name="url" content="<?php echo current_url() ?>">
	<meta name="identifier-URL" content="<?php echo current_url() ?>">
	<meta name="revisit-after" content="7 days">
	<meta name="keywords" content="corona,surgical mask,influenza"/>

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo current_url() ?>">
	<meta property="og:title" content="<?php echo empty($head['title'])?"Mask Finder":$head['title'];?>">
	<meta property="og:description" content="<?php echo empty($head['description'])?"Join the biggest community and help others to fight Corona Virus together! Let others know by sharing your latest surgical mask bought location through our mask finder. ":$head['description'];?>">
	<meta property="og:image" content="<?php echo empty($head['image']['meta'])?site_url("assets/images/meta_cover.png",'https'):site_url("assets/images/blog/meta/{$head['image']['meta']}",'https') ;?>">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?php echo current_url() ?>">
	<meta property="twitter:title" content="<?php echo empty($head['title'])?"Mask Finder":$head['title'];?>">
	<meta property="twitter:description" content="<?php echo empty($head['description'])?"Join the biggest community and help others to fight Corona Virus together! Let others know by sharing your latest surgical mask bought location through our mask finder. ":$head['description'];?>">
	<meta property="twitter:image" content="<?php echo empty($head['image']['meta'])?site_url("assets/images/meta_cover.png",'https'):site_url("assets/images/blog/meta/{$head['image']['meta']}",'https') ;?>">

	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo image_url("assets/images/favicon/") ?>apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo image_url("assets/images/favicon/") ?>favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo image_url("assets/images/favicon/") ?>favicon-16x16.png">
	<link rel="manifest" href="<?php echo image_url("assets/images/favicon/") ?>site.webmanifest">
	<link rel="mask-icon" href="<?php echo image_url("assets/images/favicon/") ?>safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
	<!-- Libs CSS -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
	<link href="<?php echo base_url("assets/plugin/") ?>selectize/dist/css/selectize.css" rel="stylesheet"/>
	<!-- FlatPick - Datetime Picker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.3/flatpickr.min.css" integrity="sha256-Zh4AVwxlwpUo2c5u4Z5emTmYZxbCk972ewf4tqGRsBg=" crossorigin="anonymous" />
	<!-- Nou Slider -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.3/nouislider.min.css" integrity="sha256-IQnSeew8zCA+RvM5fNRro/UY0Aib18qU2WBwGOHZOP0=" crossorigin="anonymous" />
	<!-- Tabler Core -->
	<link href="<?php echo base_url("assets/css/") ?>tabler.min.css" rel="stylesheet"/>
	<!-- Tabler Plugins -->
	<link href="<?php echo base_url("assets/css/") ?>tabler-flags.min.css" rel="stylesheet"/>
	<link href="<?php echo base_url("assets/css/") ?>tabler-payments.min.css" rel="stylesheet"/>
	<link href="<?php echo base_url("assets/css/") ?>tabler-buttons.min.css" rel="stylesheet"/>
	<link href="<?php echo base_url("assets/css/") ?>custom.css" rel="stylesheet"/>
	<style>
	body {
		display: none;
	}
	</style>

	<!-- Google  -->
	<!-- Login API -->
	<meta name="google-signin-client_id" content="<?php echo GOOGLE_SIGNIN_CLIENT_ID ?>">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<!-- Map Api -->
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API ?>&libraries=places"></script>
	<!-- Analytics -->
	<?php if (!empty(GOOGLE_ANALYTICS_ID)): ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo GOOGLE_ANALYTICS_ID ?>"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo GOOGLE_ANALYTICS_ID ?>');
		</script>
	<?php endif; ?>
	<!-- Adsense -->
	<script data-ad-client="ca-pub-5318074220584806" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
