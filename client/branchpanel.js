Ext.ns('Gittorama');

Gittorama.BranchPanel = Ext.extend(Ext.TabPanel, {

	repositoryName: null,

	initComponent: function()
	{
		var config = {
			region: 'center',
			activeItem: 0,
			border: false,
			margins: '0 5 5 0',
			items: [
				{
					layout: 'border',
					title: 'Commits',
					bodyBorder: false,
					defaults: {
						collapsible: true,
						split: true,
						animFloat: false,
						autoHide: false,
						useSplitTips: true
					},
					items: [
						{
							ref: '../commitContent',
							title: 'Commit content',
							region: 'south',
							height: 150,
							minSize: 75,
							maxSize: 250,
							cmargins: '5 0 0 0',
							bodyStyle: 'padding:15px'
						},{
							ref: '../lastCommits',
							region:'west',
							xtype: 'commitsgrid',
							repositoryName: this.repositoryName
						},{
							ref: '../commitDetails',
							title: 'Commit details',
							collapsible: false,
							region: 'center',
							margins: '5 0 0 0',
							html: 'author...',
							bodyStyle: 'padding:15px'
						}
					]
				},
				{
					ref: '../filesTree',
					title: 'Tree'
				}
			]
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.BranchPanel.superclass.initComponent.apply(this, arguments);
	},

	selectBranch: function(branchName)
	{
		this.commitContent.update('');
		this.commitDetails.update('');
		this.lastCommits.store.load({
			params: {
				branch: branchName
			}
		});
	}

});

Ext.reg('branchpanel', Gittorama.BranchPanel);