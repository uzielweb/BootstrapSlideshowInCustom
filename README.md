# Bootstrap Slideshow In Custom Joomla Module
Bootstrap Slideshow In Custom Module using Custom Module Override.

## How to use it
- upload the file **bootstrap-slideshow** inside /yourtemplate/html/mod_custom/
- create a module and choose **bootstrap-slideshow** as layout
- insert in module class sufix field this above:
 myownposition show_indicators show_controls ratio-21
or this above:
 slideshow hide_indicators hide_controls ratio-21
 - Save and create the other modules to each desired slide item and put in the position "myownposition"
 
 
### Aditional features
If ou set a background image to the module, so the aspect ratio can be set to anothers, like  ratio-16

# Folder Bootstrap Slideshow In Custom Joomla Module
Get all images from a folder and mount a Bootstrap Slideshow In Custom Module using Custom Module Override.

## How to use it
- upload the file **folder-bootstrap-slideshow** inside /yourtemplate/html/mod_custom/
- create a module and choose **folder-bootstrap-slideshow** as layout
- use the following syntax to get image folder **{galeria}folder_under_images|ratio-16x9|show_indicators|show_controls{/galeria}**
