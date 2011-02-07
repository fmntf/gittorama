Ext.ns('Gittorama');

Gittorama.CommitsGrid = Ext.extend(Ext.grid.GridPanel, {

	repositoryName: null,

	initComponent: function()
	{
		var config = {
			title: 'Last commits',
			floatable: false,
			margins: '5 0 0 0',
			width: 250,
			hideHeaders: true,
			colModel: new Ext.grid.ColumnModel({
				columns: [
					{
						id: 'hash',
						header: 'hash',
						dataIndex: 'hash'
					}
				]
			}),
			store: new Ext.data.JsonStore({
				url: '/commits/repository/' + this.repositoryName,
				root: 'commits',
				idProperty: 'hash',
				fields: [
					{name:'hash', type: 'string'}
				]
			})
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.CommitsGrid.superclass.initComponent.apply(this, arguments);

		this.on('rowclick', this.onRowClick, this);
	},

	onRowClick: function(grid, row, event)
	{
		console.log(grid.getStore().getAt(row));
	}

});

Ext.reg('commitsgrid', Gittorama.CommitsGrid);