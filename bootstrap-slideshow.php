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
// get all the module class sufixes and check if the current module has one of them
$moduleclass_sfx = explode( ' ', $params->get( 'moduleclass_sfx' ) );
$position = $moduleclass_sfx[1];
$show_indicators = $moduleclass_sfx[2];
$show_controls = $moduleclass_sfx[3];
$ratio = $moduleclass_sfx[4];
// load modules in the position specified by $position with attributes specified by $params
//  get all the modules in the position specified by $position
$doc = Factory::getDocument();
$module_slides = JModuleHelper::getModules( $position);
$attribs = array( 'style' => 'sp-xhtml' );
$renderer = $doc->loadRenderer( 'module' );
?>
<div id="<?php echo $modId; ?>" class="mod-custom custom">
    <?php echo $module->content; ?>
    <div class="boostrap-slideshow">
        <div id="boostrapcarousel<?php echo $module->id; ?>" class="carousel slide" data-bs-ride="carousel">
            <?php if ($show_indicators == 'show_indicators') { ?>
            <ol class="carousel-indicators">
                <?php
            $i = 0;
            foreach ($module_slides as $mod) {
                echo '<li data-bs-target="#boostrapcarousel' . $module->id . '" data-bs-slide-to="' . $i . '" class="' . ($i == 0 ? 'active' : '') . '"></li>';
                $i++;
            }
            ?>
            </ol>
            <?php } ?>
            <div class="carousel-inner">
                <?php
            $i = 0;
            foreach ($module_slides as $c=>$mod) {
                echo '<div class="carousel-item ' . ($i == 0 ? 'active' : '') . '">';
                  // get the backgroundimage
                  $modParams = new JRegistry($mod->params);
                  $backgroundimage = $modParams->get('backgroundimage');
                  // if image_as_background is set to image_as_background, render module content  first image as background
                  if ($backgroundimage) {
                //    apply ratio to background image
                $newratio = $ratio ? ' ratio '.$ratio.'x9' : ' ratio ratio-16x9';
             
                // wrap module content using the ratio class and in a container
                $mod->content = '<div class="module-content' . $newratio . '"><div class="inner"><div class="container main-text">' . $mod->content . '</div></div></div>';
                echo $renderer->render($mod, $attribs);
                   }
                else{
                    echo $renderer->render($mod, $attribs);
                }
                $i++;
                echo '</div>';
            }
            ?>
            </div>
            <?php if ($show_controls == 'show_controls') { ?>
            <a class="carousel-control-prev" href="#boostrapcarousel<?php echo $module->id; ?>" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#boostrapcarousel<?php echo $module->id; ?>" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
