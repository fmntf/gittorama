Ext.ns('Gittorama');

Gittorama.CommitPatch = Ext.extend(Ext.Panel, {

	repositoryName: 'Repository',

	initComponent: function()
	{
		var config = {
			title: 'Commit content',
			region: 'south',
			height: 150,
			minSize: 75,
			maxSize: 250,
			cmargins: '5 0 0 0',
			bodyStyle: 'padding:15px'
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.CommitPatch.superclass.initComponent.apply(this, arguments);
	},

	loadPatch: function(hash)
	{
		Ext.Ajax.request({
			url: '/show',
			success: function()
			{

			},
			failure: function()
			{

			},
			params: {
				repository: this.repositoryName,
				hash: hash
			}
		});
	}

});

Ext.reg('commitpatch', Gittorama.CommitPatch);