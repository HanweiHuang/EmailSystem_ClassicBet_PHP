var FuseApp = {
	
	'pluginArray': {},
	
	registerManager: function (name, Obj) {
		// console.log ('registerPlugin: ' + name + ' obj: ' + Obj);
		this.pluginArray[name.toLowerCase()] = Obj;
	},
	getManager: function (name) {
		var thePlugin = this.pluginArray[name.toLowerCase()];
		console.log ('getPlugin: ' + thePlugin);
		return thePlugin;

		/* Can check and load... can't be async so would need to do at start of a js and callback
		$.getScript( "/assets/js/Fusev2/" + name + ".js" )
		  .done(function( script, textStatus ) {
			console.log( 'Script status: ' + textStatus );
			
			fuse_item.sendData();
			
			return fuse_item;
			
		  })
		  .fail(function( jqxhr, settings, exception ) {
			$( "div.log" ).text( "Triggered ajaxError handler." );
		});	
		*/
		
	}
};
