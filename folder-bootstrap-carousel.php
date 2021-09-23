<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
$modId = 'mod-custom' . $module->id;
if ($params->get('backgroundimage'))
{
	/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
	$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
	$wa->addInlineStyle('
#' . $modId . '{background-image: url("' . Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url . '");}
', ['name' => $modId]);
}
// pega parametros do módulo a partir de cada parte do sufixo
?>
<div id="<?php echo $modId; ?>" class="mod-custom custom">
<!-- get content between {galeria} and  {/galeria}  in $module->content text-->
<?php
$maincontent = $module->content;
$maincontent = explode('{galeria}', $maincontent);
$maincontent = explode('{/galeria}', $maincontent[1]);
$maincontent = $maincontent[0];
// pega parametros a partir de cada parte do $content separado por |
$contentParams = explode('|', $maincontent);
// if array index exists	
$content = isset($contentParams[0]) ? $contentParams[0] : '';
$ratio = isset($contentParams[1]) ? $contentParams[1] : '';
$show_controls = isset($contentParams[2]) ? $contentParams[2] : '';
$show_indicators =  isset($contentParams[3]) ? $contentParams[3] : '';
// $content contém o nome de uma pasta com imagens
$path = JPATH_SITE . '/images/' . $content;
$images = glob($path . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
$images = array_map('basename', $images);
;
?>
<?php
// carregar imagens em um slideshow bootstrap estilo 5.0 (data-bs) com id=carousel+id do modulo
?>
<div id="bootstrapCustomCarousel<?php echo $module->id; ?>" class="bootstrapCustomCarousel carousel-fade carousel slide" data-bs-interval="3000" data-bs-ride="carousel">
<?php
if ($show_indicators == 'show_indicators') :?>	
<ol class="carousel-indicators">
		<?php
		$i = 0;
		foreach ($images as $image)
		{
			?>
			<li data-bs-target="#bootstrapCustomCarousel<?php echo $module->id; ?>" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
			<?php
			$i++;
		}
		?>
	</ol>
<?php endif; ?>
	<div class="carousel-inner">
		<?php
		$newratio = $ratio ? ' ratio '.$ratio : ' ratio ratio-16x9';
		$i = 0;
		foreach ($images as $image)
		{
			?>
			<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?> <?php echo $newratio; ?>" style="background: url('<?php echo Uri::root(true) . '/images/' . $content . '/' . $image; ?>') no-repeat center center; background-size: cover;">
			</div>
			<?php
			$i++;
		}
		?>
	</div>
	<?php if ($show_controls == 'show_controls') : ?>
	<a class="carousel-control-prev" data-bs-target=#bootstrapCustomCarousel<?php echo $module->id; ?>" role="button" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" data-bs-target="#bootstrapCustomCarousel<?php echo $module->id; ?>" role="button" data-bs-slide="next">
	<span class="carousel-control-next-icon" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
	</a>
	<?php endif; ?>
</div>
</div>
<!-- end of slideshow -->
</div>
