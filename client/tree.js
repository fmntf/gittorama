Ext.ns('Gittorama');

Gittorama.Tree = Ext.extend(Ext.Panel, {

	repositoryName: 'Repository',

	initComponent: function()
	{
		var config = {
			title: 'Tree',
			layout:'hbox',
			layoutConfig: {
				align : 'stretch',
				pack  : 'start',
			},
			items: [
				{
					ref: 'filesTree',
					xtype: 'treepanel',
					flex: 2,
					useArrows: true,
					autoScroll: true,
					animate: true,
					containerScroll: true,
					border: false,
					dataUrl: '/tree',
					root: {
						nodeType: 'async',
						text: '/',
						draggable: false,
						id: 'HEAD'
					}
				},{
					ref: 'fileContent',
					autoScroll: true,
					bodyStyle: 'background-color: #efefef;',
					flex: 6,
					border: false
				}
			]
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.Tree.superclass.initComponent.apply(this, arguments);
		this.filesTree.loader.baseParams.repository = this.repositoryName;

		this.mon(this.filesTree, 'click', this.onNodeClick, this);
	},

	selectBranch: function(hash)
	{
		this.filesTree.getRootNode().id = hash;
		// reload tree
	},

	onNodeClick: function(node)
	{
		if (node.isLeaf()) {
			Ext.Ajax.request({
				url: '/blob',
				success: function(result)
				{
					this.fileContent.update(result.responseText);
				},
				failure: function()
				{
				},
				params: {
					hash: node.id,
					name: node.attributes.text,
					repository: this.repositoryName
				},
				scope: this
			});
		}
	}

});

Ext.reg('gitree', Gittorama.Tree);