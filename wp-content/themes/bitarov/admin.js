function elem(id)
 {
 return document.getElementById(id);
 }

function catSelect()
 {
 var id_cat = parseInt(this.value);

 }

function catsHook()
 {
 $('input[name="post_category[]"]').click(catSelect);
 }

function docLoad()
 {
 $('#post').attr('enctype', 'multipart/form-data');
 }
$(window).ready(docLoad);