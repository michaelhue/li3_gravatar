# Gravatar Plugin for Lithium

The Lithium Gravatar plugin (Li3 Gravatar) allows you to interact with Gravatar (http://gravatar.com) images and profiles. It provides a helper for displaying Gravatars and a model for requesting user profiles from Gravatar.


## Rendering Gravatars in your views

The plugin comes with a helper which makes it very easy to display Gravatars in your views:

	// Renders an <img> tag with the Gravatar for mail@example.org
	<?=$this->gravatar->image('mail@example.org'); ?>

You may use the options `'default'`, `'size'` and `'rating'` and/or any HTML attribute to adjust the output to your needs.

	// Renders an <img> tag with the class "gravatar", a fallback image on the server and a different size.
	<?=$this->gravatar->image('mail@example.org', array(
		'default' => '/img/avatar.png',
		'size' => 40,
		'class' => 'gravatar'
	));

In case you only need the URL of the Gravatar (for example in order to improve initial load times by creating the <img> tags via JavaScript), the `url` method is what you want:

	<div class="gravatar" data-image="<?=$this->gravatar->url('mail@example.org'); ?>"></div>

## Retrieving profiles from Gravatar

The `GravatarProfiles` model allows you to fetch public profile information from Gravatar:

	use li3_gravatar\models\GravatarProfiles;
	$profile = GravatarProfiles::fetch('mail@example.org');

For more information on Gravatar profiles please refer to http://gravatar.com/site/implement/profiles/.

Please note: The model doesn't use a database connection. In order to store the profile data you need to create your own model.