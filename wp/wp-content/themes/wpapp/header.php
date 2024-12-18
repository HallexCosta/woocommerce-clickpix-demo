<?php 
    $post_id = get_the_ID();

    $title_default = trim(get_bloginfo('name'));
    $description_default = trim(get_bloginfo('description'));
    $image_default = 'REAL_FAVICON_IMAGE';
    
    $metadata = [
        'title' => $title_default,
        'description' => $description_default
    ];

    if (is_plugin_active( 'smartcrawl-seo/wpmu-dev-seo.php' )) {
        $seo_title = get_post_meta($post_id , '_wds_title', true); // Smartcrawl SEO Title
        $seo_description = get_post_meta($post_id , '_wds_metadesc', true); // Smartcrawl SEO Site
        $seo_permalink = get_permalink($post_id);
        $seo_type = is_single() ? 'article' : 'website';

        // Facebook
        $seo_opengraph = get_post_meta($post_id , '_wds_opengraph', true); // Smartcrawl SEO Facebook
        $seo_opengraph_image_id = '';
        $seo_opengraph_image_exist = '';
        $seo_opengraph_image = '';
        if (!empty($seo_opengraph)) {
            $seo_opengraph_image_id = isset($seo_opengraph['images']) ? $seo_opengraph['images'][0] : null;
            $seo_opengraph_image_exist = wp_get_attachment_image_url($seo_opengraph_image_id, 'thumbnail');
            $seo_opengraph_image =  $seo_opengraph_image_exist ? wp_get_attachment_image_url($seo_opengraph_image_id, 'thumbnail') : 'URL_DEFAULT';
        }

        // Twitter
        $seo_twitter = get_post_meta($post_id , '_wds_twitter', true); // Smartcrawl SEO Twitter
        $seo_twitter_image_id = '';
        $seo_twitter_image_exist = '';
        $seo_twitter_image = '';
        if (!empty($seo_twitter)) {
            $seo_twitter_image_id = isset($seo_twitter_image['images']) ? $seo_twitter_image['images'][0] : null; // Smartcrawl SEO
            $seo_twitter_image_exist = wp_get_attachment_image_url($seo_twitter_image_id, 'thumbnail');
            $seo_twitter_image = $seo_twitter_image_exist ? wp_get_attachment_image_url($seo_twitter_image_id, 'thumbnail') : '';
        }
    }

    // Twitter Cards (summary_large_image)
    // Tamanho recomendado: 1200 x 628 pixels
    // Tamanho mínimo: 300 x 157 pixels
    //
    //
    // Open Graph (Facebook, LinkedIn, etc.)
    // Tamanho recomendado: 1200 x 630 pixels
    // Tamanho mínimo: 600 x 315 pixels
    $metadata = [
        'title' => !empty($seo_title) ? $seo_title : $title_default,
        'description' => !empty($seo_description) ? $seo_description : $description_default,
        'opengraph' => [
            'title' => !empty($seo_opengraph['title']) ? $seo_opengraph['title'] : $title_default,
            'description' => !empty($seo_opengraph['description']) ? $seo_opengraph['description'] : $description_default,
            'image' => !empty($seo_opengraph_image) ? $seo_opengraph_image : $image_default,
        ],
        'twitter' => [
            'title' => !empty($seo_twitter['title']) ? $seo_twitter['title'] : $title_default,
            'description' => !empty($seo_twitter['description']) ? $seo_twitter['description'] : $description_default,
            'image' => !empty($seo_twitter_image) ? $seo_twitter_image : $image_default,
        ],
        'permalink' => $seo_permalink,
        'type' => $seo_type
    ];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<!--[if IE 7 ]>    <html lang="pt-BR" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="pt-BR" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="pt-BR" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="pt-BR" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Metadata -->
    <title><?php echo $metadata['title']; ?></title>
    <meta name="description" content="<?php echo $metadata['description']; ?>" />

    <!-- Opengraph -->
    <meta property="og:title" content="<?php echo $metadata['opengraph']['title']; ?>" />
    <meta property="og:description" content="<?php echo $metadata['opengraph']['description']; ?>" />
    <meta property="og:image" content="<?php echo $metadata['opengraph']['image']; ?>" />
    <meta property="og:url" content="<?php echo $metadata['permalink']; ?>" />
    <meta property="og:type" content="<?php echo $metadata['type']; ?>" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $metadata['twitter']['title']; ?>" />
    <meta name="twitter:description" content="<?php echo $metadata['twitter']['description']; ?>" />
    <meta name="twitter:image" content="<?php echo $metadata['twitter']['image']; ?>" />
    <meta name="twitter:url" content="<?php echo $metadata['permalink']; ?>" />

    <!-- CSS -->
    <link href="<?php echo getTheme('style.css', getAppVersion()); ?>" rel="stylesheet" media="all" />
</head>

<body>
