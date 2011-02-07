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
						useSplitTips: true,
						bodyStyle: 'padding:15px'
					},
					items: [
						{
							ref: '../commitContent',
							title: 'Commit content',
							region: 'south',
							height: 150,
							minSize: 75,
							maxSize: 250,
							cmargins: '5 0 0 0'
						},{
							ref: '../lastCommits',
							title: 'Last commits',
							region:'west',
							floatable: false,
							margins: '5 0 0 0',
//							cmargins: '5 5 0 0',
							width: 175,
//							minSize: 100,
//							maxSize: 250,
							items: [
								{
									xtype: 'multiselect',
									border: false,
									plain: true,
									store: {
										url: '/commits/repository/' + this.repositoryName,
										root: 'images',
										idProperty: 'name',
										fields: ['name', 'url', {name:'size', type: 'float'}, {name:'lastmod', type:'date'}]
									}
								}
							]
						},{
							ref: '../commitDetails',
							title: 'Commit details',
							collapsible: false,
							region: 'center',
							margins: '5 0 0 0',
							html: 'author...'
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
		this.lastCommits.items.items[0].store.load();
	}

});

Ext.reg('branchpanel', Gittorama.BranchPanel);