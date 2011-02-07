Ext.ns('Gittorama');

Gittorama.CommitPanel = Ext.extend(Ext.Panel, {

	repositoryName: 'Repository',

	initComponent: function()
	{
		var config = {
			title: 'Commit details',
			collapsible: false,
			region: 'center',
			margins: '5 0 0 0',
			bodyStyle: 'padding:15px'
		};

		Ext.apply(this, Ext.apply(this.initialConfig, config));

		Gittorama.CommitPanel.superclass.initComponent.apply(this, arguments);
		
		this.menuContext = new Ext.menu.Menu({
			items: [{
				id: 'opentree',
				text: 'Open tree'
			}],
			listeners: {
				itemclick: {
					fn: function()
					{
						this.fireEvent('opentree', this.lastClickedHash);
					},
					scope: this
				}
			}
		});
	},

	showCommit: function(commitRecord)
	{
		var parent = '';
		if (commitRecord.get('parent') != '') {
			parent = this.label('Parent:') + this.hash(commitRecord.get('parent'));
		} else if (commitRecord.get('parents') != '') {
			parent = this.label('Parents:') + 
					this.hash(commitRecord.get('parents')[0] + ', ' + commitRecord.get('parents')[1]);
		}

		var l = this.label('Message:') + '<p>' + commitRecord.get('message') + '</p><br />' +
				this.label('Hash:') + this.hash(commitRecord.get('hash')) + parent +
				this.label('Tree:') + this.hash(commitRecord.get('tree'));

		var r = this.label('Author:') + this.person(commitRecord.get('author')) + '<br /><br />' +
				this.label('Committer:') + this.person(commitRecord.get('committer'));

		var html = String.format('<table width="100%"><tr><td width="50%">{0}</td><td>{1}</td></tr></table>', l, r);
		this.update(html);
		
		this.enableHashes();
	},
	
	enableHashes: function()
	{
		Ext.each(this.el.query('code'), function(hash){
			var el = Ext.fly(hash);
			el.on('contextmenu', this.onContextMenu, this);
		}, this);
	},
	
	onContextMenu: function(event, dom)
	{
		event.stopEvent();
		this.lastClickedHash = dom.innerHTML;
		this.menuContext.showAt(event.xy);
	},

	label: function(label)
	{
		return '<span style="color:gray;">' + label + '</span><br />';
	},

	hash: function(hash)
	{
		return '<p><code>' + hash + '</p></code>';
	},

	person: function(person)
	{
		var ts = new Date(person.timestamp*1000);
		return person.name + '<br /><' + person.email + '>' +
			ts.format('d/m/Y H:i');
	}

});

Ext.reg('commitpanel', Gittorama.CommitPanel);