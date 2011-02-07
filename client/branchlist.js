Ext.ns('Gittorama');

Gittorama.BranchList = Ext.extend(Ext.tree.TreePanel, {

	repositoryName: 'Repository',

	initComponent: function()
	{
		var config = {
			title: 'Branches',
			region:'north',
			split: true,
			height: 300,
			minSize: 150,
			autoScroll: true,

			// tree-specific configs:
			rootVisible: false,
			lines: false,
			singleExpand: true,
			useArrows: true,

			dataUrl: '/branches/repository/' + this.repositoryName,
			root: {
//				expanded: true,
				nodeType: 'async'
			}
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.BranchList.superclass.initComponent.apply(this, arguments);

		this.on('click', this.onBranchSelect, this);
	},

	onBranchSelect: function(node)
	{
		this.fireEvent('branchselect', node.text, node.attributes.description);
	}

});

Ext.reg('branchlist', Gittorama.BranchList);