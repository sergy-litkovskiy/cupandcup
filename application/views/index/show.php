<h1><?php echo @$content->title;?></h1>
<?php if($contact_map){?>
<div class="print_page">
    <a href="#" onclick="javascript:window.print()">
        <img src="<?php echo base_url();?>img/img_main/printer_page.png"/>
        <p>Распечатать</p>
    </a>
</div>
<?php };?>
<?php echo $content->description;?>
<?php if($contact_map){ echo $contact_map; };?>
<?php if($contact_form){ echo $contact_form; };?>