Fuse_data = function()
{
	this.currentNode = null;
	this.callbackObject = null;
	this.callbackMethod = null;		
	// console.log ('Fuse data');
	FuseApp.registerManager('data', this);	
	
}

Fuse_data.prototype.sendData = function(node, dataArray, callbackObject, callbackMethod)
{
	
	this.callbackObject = callbackObject;
	this.callbackMethod = callbackMethod;
	
	var urlExtra = '';
	var itemNode = FuseApp.getManager('interface').getParentBy(node, 'scope', 'item');
	console.log ('sendData node: ' + node + ' dataArray: ' + dataArray + ' type: ' + typeof(values) + ' itemAttr: ' + itemNode.attr('data-type'));
	
	/*
	var allInputs = values.find( ":input" );
	allInputs.each(function( index ) {
  		if ($( this ).attr('name') != null) console.log( index + ": " + $( this ).attr('name') + ' - ' + $( this ).val() );
	});
	*/
	
	if (itemNode.attr('data-ref') != null) urlExtra += '&itemRef=' +  itemNode.attr('data-ref');
	urlExtra += '&tabId=' +  node.attr('id');
	
	this.currentNode = itemNode;
	$.post('contact_submit.php?' + urlExtra, dataArray, function(data, textStatus) {
	  //data contains the JSON object
	  //textStatus contains the status: success, error, etc
	  
	  FuseApp.getManager('data').processCall(data);
	  
	}, "json");
			
}

Fuse_data.prototype.processCall = function(data)
{
	console.log ('processCall: ' + data.itemRef + ' node: ' + this.currentNode.attr('data-type'));
	this.currentNode.attr('data-ref', data.itemRef);
	
	this.callbackObject[this.callbackMethod](data);
	
}



new Fuse_data();