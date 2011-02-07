Ext.ns('Gittorama');

Gittorama.Viewport = Ext.extend(Ext.Viewport, {

	repositoryName: 'Repository',
	repositoryDescription: '',

	initComponent: function()
	{
		var config = {
			layout: 'border',
			title: this.repositoryName,
			items: [
				{
					xtype: 'box',
					region: 'north',
					applyTo: 'header',
					height: 30
				},{
					layout: 'border',
					region:'west',
					border: false,
					split:true,
					margins: '2 0 5 5',
					width: 275,
					items: [
						{
							xtype: 'branchlist',
							repositoryName: this.repositoryName,
							ref: '../branchList'
						},
						{
							xtype: 'detailpanel',
							ref: '../repositoryDetails',
							html: this.repositoryDescription
						}
					]
				},{
					xtype: 'branchpanel',
					repositoryName: this.repositoryName,
					ref: 'branchPanel'
				}
			],
			renderTo: Ext.getBody()
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.Viewport.superclass.initComponent.apply(this, arguments);

		this.mon(this.branchList, 'branchselect', this.onBranchSelect, this);
	},

	onBranchSelect: function(newBranch, description, hash)
	{
		this.repositoryDetails.setDescription(this.repositoryDescription, newBranch, description);

		this.branchPanel.selectBranch(newBranch, hash);
	}

});

Ext.reg('gitviewport', Gittorama.Viewport);