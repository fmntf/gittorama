Ext.ns('Gittorama');

Gittorama.DetailPanel = Ext.extend(Ext.Panel, {

	initComponent: function()
	{
		var config = {
			title: 'Repository Details',
			region: 'center',
			bodyStyle: 'padding-bottom:15px;background:#eee;',
			autoScroll: true
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.DetailPanel.superclass.initComponent.apply(this, arguments);
	},

	setDescription: function(repo, branchName, branchDescription)
	{
		var html = repo + '<br /><br />' + '# On branch ' + branchName + '<br />'
					+ '# ' + branchDescription;
		this.update(html);
	}

});

Ext.reg('detailpanel', Gittorama.DetailPanel);