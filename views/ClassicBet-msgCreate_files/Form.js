Fuse_form = function()
{
	// console.log ('Fuse form');
	FuseApp.registerManager('form', this);	
	
}

Fuse_item.prototype.getFieldValues = function(form)
{
	console.log ('getFieldValues form: ' + form);	
}

var fuse_form = new Fuse_form();

$("body").ready(function(){
	
	$(".add_another button").on('click', function(){
			
			var topNode = $(this).closest('.add_another');
			var itemList = topNode.find('.add_list:first');
			var itemItem = topNode.find('.add_item:first');
			console.log("Click list: " + itemList + ' itemItem: ' + itemList.length + ' ' + itemList.children().length);
				
			var newItem = itemItem.clone(1).appendTo( itemList );
			var itemName = topNode.find('.add_item:first input').attr('name');
			var newName = itemName.substring(0,itemName.length-1) + String(itemList.children().length);
			newItem.find('input').val('').attr('name', newName);
			newItem.find('input:hidden').attr('name', newName+'_hidden');
			newItem.find('select').attr('name', newName+'_type');
				
	});
	
	$("div.add_item .icon-trash").on('click', function(){
			
			console.log ('click: ' + $(this)); 
			
			var disInput = $(this).closest('.inputDiv').find('input.isDisabled');
			
			if (disInput.attr('value') == 'false')
			{
				$(this).closest('.add_item').find('input,select').each(function() {$(this).attr('disabled',''); } );
				$(this).closest('.add_item').find('.isDisabled').attr('value', 'true');				
			}	else	{
				$(this).closest('.add_item').find('input,select').each(function() {$(this).attr('disabled','disabled'); } );
				$(this).closest('.add_item').find('.isDisabled').attr('value', 'false');
			}
	});
	
	$("input.checkUnique").blur(function(){
			
			var inputIcon = $(this).closest('.input-group').find('.input-group-addon i');
			console.log ('checkUnique: ' + $(this) + ' inputIcon: ' + inputIcon); 
			
			inputIcon.removeClass().addClass('icon-cog');
			
	});
	
	
	
	
	


});