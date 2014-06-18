Fuse_interface = function()
{
	// console.log ('Fuse interface');
	FuseApp.registerManager('interface', this);	
	
}

Fuse_interface.prototype.getParentNode = function(node)
{
	var currNode = node;
	while (currNode != null && currNode.prop("tagName").toLowerCase() != 'body')
	{
		if (currNode.attr('data-scope') == nodeRef) 
		{
			// console.log (' p - ' + (currNode.attr('data-scope')) + ' ' + currNode.prop("tagName").toLowerCase());
			str += '<option value="' + currNode.attr('id') + '">' + toTitleCase(currNode.attr('data-scope')) + '</option>'
		}
		currNode = currNode.parent();
	}
	if (currNode != node) return currNode;
}

Fuse_interface.prototype.getParentBy = function(node, attribute, value)
{
  while (node.attr('id') != 'body' && node.attr('data-' + attribute) != value)
  {
	  node = node.parent();		
	  // console.log ('node: ' + typeof(node) + ' ' + node.prop('tagName') );
  }		
  if (node.attr('data-' + attribute) != null) return node;
}

var fuse_interface = new Fuse_interface();