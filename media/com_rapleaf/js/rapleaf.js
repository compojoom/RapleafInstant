Rapleaf = new Class( {
	Implements: [Options, Events],
	errors : {
//		count the rapleaf errors
		rapleaf : 0
	},
//	number of joomla users
	joomlaUsers : 0,
	offset: 0,
	maxRequestsAtOnce: 5,
	options : {
		onUserTableEmpty: function() {
			var self = this;
			var request = new Request.JSON({
				'url': this.options.url + 'index.php?option=com_rapleaf&view=users&task=count&format=raw',
				onRequest: function() {
					self.spanElement('Calculating how many joomla users you have');
//					document.id('rapleaf-report-info').set('html', '')
				},
				onSuccess: function(json) {
					if(json.status == 'success') {
						self.spanElement('You have ' + json.number + 'users. ');
//						document.id('rapleaf-report-info').set('html', );
						self.joomlaUsers = json.number;
						self.fireEvent('getRapleafData');
					} else {
						self.spanElement('Something went wrong');
//						document.id('rapleaf-report-info').set('html', 'Something went wrong')
					}
				}
			}).send();
		},
		onGetRapleafData: function() {
			var self = this;
			var request = new Request.JSON({
				'url': this.options.url + 'index.php?option=com_rapleaf&view=rapleaf&task=getUserData&format=raw',
				onRequest: function() {
					self.spanElement('Contacting rapleaf to get user data');
//					document.id('rapleaf-report-info').set('html', 'Contacting rapleaf to get user data');
				},
				onSuccess: function(json) {
					if(json.status == 'success') {
						self.spanElement('Rapleaf response was good. We have saved the users in the database');
//						document.id('rapleaf-report-info').set('html', 'Rapleaf response was good. We have saved the users in the database');
//						reset rapleaf's error counter
						self.errors.rapleaf = 0;
						self.offset += self.maxRequestsAtOnce;
						if(self.offset < self.joomlaUsers) {
							self.fireEvent('getRapleafData');
						} else {
							self.fireEvent('generateReport');
						}
					} else {
						if (json.type == 'rapleaf') {
							if(self.errors.rapleaf < 3) {
								self.spanElement('There was something wrong with the request to rapleaf. We will try again to get the data.');
//								document.id('rapleaf-report-info').set('html', 'There was something wrong with the request to rapleaf. We will try again to get the data.');
								self.errors.rapleaf +=1;
								self.fireEvent('getRapleafData');
							} else {
								self.spanElement('Unfortunatly for some reason the rapleaf service is not available. Please try later.');

//								document.id('rapleaf-report-info').set('html', 'Unfortunatly for some reason the rapleaf service is not available. Please try later.');
							}
						} else {
							self.spanElement('Something went wrong');
//							document.id('rapleaf-report-info').set('html', 'Something went wrong')
						}
						
					}
					
				}
			}).send('offset='+self.offset+'&limit='+self.maxRequestsAtOnce);
		},
		onGenerateReport: function() {
			var self = this;
			var request = new Request.JSON({
				'url': this.options.url + 'index.php?option=com_rapleaf&view=report&task=generateReport&format=raw',
				onRequest: function() {
					document.id('rapleaf-report-info').set('html', 'Contacting rapleaf to get user data')
				},
				onSuccess: function(json) {
					if(json == 'success') {
						document.id('rapleaf-report-info').set('html', 'Report generated. We will refresh the page in 3 seconds ');
						setTimeout(function() {
							window.location.reload(true);
						}, 3000);
						this.fireEvent('generateReport');
					} else {
						document.id('rapleaf-report-info').set('html', 'Something went wrong')
					}
					
				}
			}).send();
		},
		
		'url' : ''
	},
	
	initialize: function(options) {
		this.setOptions(options)
		
		
		this.attachEvent();
		
		
	},
	
	attachEvent: function() {
		var reportButton = document.id('rapleaf-generate-report');
		if(reportButton) {
			reportButton.addEvent('click', function() {
				this.initializeReport();
			}.bind(this));
		}
		
		var selectReport = document.id('reports');
		if(selectReport) {
			selectReport.addEvent('change', function() {
				this.compareReports();
			}.bind(this));
		}
		
		var form = document.id('form-compare');
		if(form) {
			form.addEvent('submit', function(e) {
				e.stop();
				this.compareReports();
			}.bind(this))
		}
		
	},
	
	compareReports: function() {
		var request = new Request.HTML({
			'url': this.options.url + 'index.php?option=com_rapleaf&view=report&task=compare&format=raw',
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScrip) {
				document.id('comparison').set('html',responseHTML);
			}
		}).send('reports='+document.id('reports').get('value'));
	},
	
	initializeReport: function() {
		this.effects();
		this.deleteUsers();
	},
	
	deleteUsers: function() {
		var self = this;
		var request = new Request.JSON({
			'url': this.options.url + 'index.php?option=com_rapleaf&view=users&task=deleteAll&format=raw',
			onRequest: function() {
				self.spanElement('Empty rapleaf user table...')
			},
			onSuccess: function(json) {
				if(json == 'success') {
					self.spanElement('Rapleaf user table emptyed.');
					self.fireEvent('userTableEmpty');
				} else {
					self.spanElement('We are sorry, but somethign went wrong.')
					self.fireEvent('rapleafUserTableFailureEmpty');
				}
				
			}
		}).send();
	},
	
	spanElement: function(text) {
		var element = new Element('span', {
			'class' : 'fadein',
			'html' : text
		}).set('tween', {'duration':'long'});
		
		document.id('rapleaf-report-info').adopt(element.fade(1));
		
		document.getElementById('rapleaf-report-info').scrollTop = document.getElementById('rapleaf-report-info').scrollHeight;
//		return element;
	},
	
	effects: function() {
		var close = new Element('span', {
			'class': 'rapleaf-close',
			events: {
				click : function(){
//					div.destroy();
				}
			}
		});
		
		var options = {
			width: 2,
			radius: 0,
			trail: 54,
			speed: 0.6
		}
		var spinner = new Spinner(options).spin();
		
		var spinnerContainer = new Element('div', {
			'class' : 'spinner'
		}).adopt(spinner.el);
		
		var spanTitle = new Element('h4', {
			'class' : 'rapleaf-title',
			'html' : 'Generating report. Please wait...'
		});
		
		var info = new Element('div', {
			'id':'rapleaf-report-info',
			'class':'rapleaf-report-info'
		});
		
		
		
		var container = new Element('div', {
			'class': 'rapleaf-report-container'
		}).adopt([spinnerContainer,spanTitle,close,info ]);
		
		var div = new Element('div', {
			'class':'rapleaf-overlay',
			events: {
				click : function(){
					div.destroy();
				}
			}
		}).adopt(container);
		
		div.inject(document.body);
		
		
//		
//		document.id('rapleaf-report-info').appendChild(spinner.el);
	}
})