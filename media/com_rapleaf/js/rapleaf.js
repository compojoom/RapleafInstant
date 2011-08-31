Rapleaf = new Class( {
	Implements: [Options, Events],
	errors : {
//		count the rapleaf errors
		rapleaf : 0
	},
//	number of joomla users
	joomlaUsers : 0,
	offset: 0,
	maxRequestsAtOnce: 1000,
	options : {
		onUserTableEmpty: function() {
			var self = this;
			var request = new Request.JSON({
				'url': this.options.url + 'index.php?option=com_rapleaf&view=users&task=count&format=raw',
				onRequest: function() {
					self.spanElement(rapleafLanguage.calculateJoomlausers);
				},
				onSuccess: function(json) {
					if(json.status == 'success') {
						self.spanElement(rapleafLanguage.youHave + ' ' + json.number + ' '+rapleafLanguage.users);
						self.joomlaUsers = json.number;
						self.fireEvent('getRapleafData');
					} else {
						self.spanElement(rapleafLanguage.wrong);
					}
				}
			}).send();
		},
		onGetRapleafData: function() {
			var self = this;
			var request = new Request.JSON({
				'url': this.options.url + 'index.php?option=com_rapleaf&view=rapleaf&task=getUserData&format=raw',
				onRequest: function() {
					self.spanElement(rapleafLanguage.getData);
				},
				onSuccess: function(json) {
					if(json.status == 'success') {
						self.spanElement(rapleafLanguage.rapleafResponseGood);
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
								self.spanElement(rapleafLanguage.contactSomethingWrong);
								self.errors.rapleaf +=1;
								self.fireEvent('getRapleafData');
							} else {
								self.spanElement(rapleafLanguage.rapleafNotAvailable);
						}
						} else {
							self.spanElement(rapleafLanguage.wrong);
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
					document.id('rapleaf-report-info').set('html', rapleafLanguage.generateReport)
				},
				onSuccess: function(json) {
					if(json == 'success') {
						document.id('rapleaf-report-info').set('html', rapleafLanguage.reportGenerated);
						setTimeout(function() {
							window.location.reload(true);
						}, 3000);
						this.fireEvent('generateReport');
					} else {
						document.id('rapleaf-report-info').set('html', rapleafLanguage.wrong)
					}
					
				}
			}).send();
		},
		
		'url' : ''
	},
	
	initialize: function(options) {
		this.setOptions(options)
		
		
		this.attachEvent();
		
		this.correctHeight();
	},	
	
	correctHeight: function() {
		var analysis = document.id('analysis');
		var comparison = document.id('comparison-info');
		
		if(analysis && comparison) {
			var analysisHeight = analysis.getSize().y;
			var comparisonHeight = comparison.getSize().y;

			if(comparisonHeight > analysisHeight) {
				analysis.setStyle('height', comparisonHeight);
			} else if(comparisonHeight < analysisHeight) {
				comparison.setStyle('height', analysisHeight);
			}
		}
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
		
		document.id('rapleaf-report-info').scrollTop = document.id('rapleaf-report-info').scrollHeight;
	},
	
	effects: function() {
		var close = new Element('span', {
			'class': 'rapleaf-close',
			events: {
				click : function(){
					div.destroy();
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
			'class':'rapleaf-overlay'
		}).adopt(container);
		
		div.inject(document.body);

	}
})