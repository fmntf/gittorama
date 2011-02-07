Ext.ns('Gittorama');

Gittorama.CommitsGrid = Ext.extend(Ext.grid.GridPanel, {

	repositoryName: null,

	initComponent: function()
	{
		var config = {
			title: 'Last commits',
			margins: '5 0 0 0',
			width: 250,
			collapsible: false,
			hideHeaders: true,
			autoExpandColumn: 'shorthash',
			cls: 'commitsgrid',
			colModel: new Ext.grid.ColumnModel({
				columns: [
					{
						id: 'shorthash',
						header: 'shorthash',
						dataIndex: 'shorthash'
					}
				]
			}),
			store: new Ext.data.JsonStore({
				url: '/commits/repository/' + this.repositoryName,
				root: 'commits',
				idProperty: 'hash',
				fields: [
					{name:'hash', type: 'string'},
					{name:'shorthash', type: 'string'},
					{name:'tree', type: 'string'},
					{name:'parent', type: 'string'},
					{name:'message', type: 'string'},
					{name:'parents', type: 'array'},
					{name:'author', type: 'object'},
					{name:'committer', type: 'object'},
				]
			})
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.CommitsGrid.superclass.initComponent.apply(this, arguments);

		this.on('rowclick', this.onRowClick, this);
	},

	onRowClick: function(grid, row, event)
	{
		var record = grid.getStore().getAt(row);

		this.fireEvent('commitselect', record);
	}

});

Ext.reg('commitsgrid', Gittorama.CommitsGrid);