Fuse_item = function()
{
	// console.log ('Fuse item');
	FuseApp.registerManager('item', this);	
}

Fuse_item.prototype.create = function(type, array)
{
	console.log ('create item: ' + type + ' vals: ' + array);	
}

var fuse_item = new Fuse_item();