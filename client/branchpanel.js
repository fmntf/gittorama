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
						repositoryName: this.repositoryName
					},
					items: [
						{
							ref: '../commitContent',
							xtype: 'commitpatch'
						},{
							ref: '../lastCommits',
							region:'west',
							xtype: 'commitsgrid'
						},{
							ref: '../commitDetails',
							xtype: 'commitpanel'
						}
					]
				},
				{
					ref: 'filesTree',
					title: 'Tree',
					xtype: 'gitree',
					repositoryName: this.repositoryName
				}
			]
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.BranchPanel.superclass.initComponent.apply(this, arguments);

		this.mon(this.lastCommits, 'commitselect', this.onCommitSelect, this);
		
		this.mon(this.commitDetails, 'opentree', this.onCommitHashTreeOpen, this);
	},
	
	onCommitHashTreeOpen: function(longHash)
	{
		var hash = longHash.substr(0, 6);
		
		var added = this.add({
			title: 'Tree (' + hash + ')',
			closable: true,
			xtype: 'gitree',
			repositoryName: this.repositoryName
		});
		
		added.selectBranch(longHash);
		this.setActiveTab(added.id);
	},

	selectBranch: function(branchName, hash)
	{
		this.commitContent.update('');
		this.commitDetails.update('');
		this.lastCommits.store.load({
			params: {
				branch: branchName
			}
		});
		this.filesTree.selectBranch(hash);
	},

	onCommitSelect: function(commitRecord)
	{
		this.commitDetails.showCommit(commitRecord);
		this.commitContent.loadPatch(commitRecord.get('hash'));
	}

});

Ext.reg('branchpanel', Gittorama.BranchPanel);