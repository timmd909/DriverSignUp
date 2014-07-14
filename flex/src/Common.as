package {
	import mx.messaging.channels.StreamingAMFChannel;

	public final class Common {
		
		public function Common() {
			trace( "I wonder if Common()' constructor ever gets called..." );
		} // public function DSUConfig()
		
				
		// -=- DEBUG / DEBUG RELATED -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		public static var SHOW_XML:Boolean = false;
		public static var SHOW_AUTOFILL:Boolean = true;
		// -=- / DEBUG / DEBUG RELATED -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		
		public static const NEWLINE:String = '\n';
		
		
		// -=- LOGO / COMPANY INFO -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		[Embed(source='img/example-logo.png')]
		public static var LOGO_DATA:Class;
		public static var LOGO_WIDTH:int = 50;
		public static var LOGO_HEIGHT:int = 75;
		public static var COMPANY_NAME:String = 'Acme Co.';
		public static var COMPANY_DESCRIPTION:String = 'Company description goes here...';
		// -=- / LOGO / COMPANY INFO -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		

		// -=- BLANKS -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		public static const BLANK_ROW:XML = new XML(  
			<ROW 
				DRVFN="Driver first name" 
				DRVMI="Middle initial" 
				MIDDLENAME="Middle Name" 
				DRVLN="Last name" 
				PHONE="4127580179" 
				DRPHON2="4127580179"
				SSN="123-45-6789" 
				EMAILADDR="tim@home.com" 
				DOB="19800101" 
				AVLDTE="20121221"
				ADRID="-1"
			
				DUI="N" 
				LICSUS="N" 
				RCKDRV="N" 
				FELONY="N"
				EMPLOYED="Y">
			
				<Addresses />
				<CDLs />
				<Comments />
 				<Signatures />
			
				<Employers />
			    <MovingViolations />
				<Felonies />

			</ROW>
		); // public static const BLANK_ROW:XML = new XML(
		
		public static const BLANK_SIGNATURE:XML = <RowSignatures JPG="" />;
		
		public static const BLANK_COMMENT:XML = <RowComments COMMNT=""/>;
		
		// -=- / BLANKS -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

		
		public static function addComment( rowXML:XML, comment:String ):void {
			var newCommentXML:XML = new XML( BLANK_COMMENT );
			newCommentXML.@COMMNT = comment;
			rowXML.Comments.appendChild( newCommentXML );
		}
		
		
		// -=- MUTABLE PUBLIC VARIABLES -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		
		public static var EXIT_URL:String = 'http://www.google.com';
		public static var SUBMIT_URL:String = 'submit-application.php';
		public static var EMAIL_ADDRESS:String = 'tim@tim-doerzbacher.com';
		public static var CONTRACT:XML = 
			<html>
				<body>
					<p>This is a sample contract. The following text is in Latin and is just used for filler.</p>
	
					<b>Donec mi dolor</b>
					<p>Lacinia eu placerat pharetra, consectetur nec risus. Duis porttitor felis vitae sem molestie et laoreet augue congue. 
					Praesent libero ipsum, elementum ac eleifend ut, cursus et nulla. Maecenas eros mi, bibendum a dapibus sit amet, sagittis vitae augue.
					Curabitur volutpat odio at tortor vulputate auctor in sit amet odio. Aliquam venenatis urna in orci eleifend venenatis. Nulla semper aliquam
					velit ut laoreet. Sed interdum ornare ligula quis vulputate. Sed erat nulla, scelerisque eu adipiscing at, molestie ut nunc. Sed eu dictum metus.
					Nulla gravida varius mauris vel mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi in diam
					ut ante congue adipiscing at imperdiet mauris. Quisque nec dui tincidunt purus ornare varius. Nam dapibus mauris sit amet arcu ultrices laoreet. 
					Nulla facilisi. Donec iaculis tellus vitae lectus blandit sed adipiscing sapien suscipit. Curabitur turpis augue, volutpat nec pretium vel, hendrerit quis quam.</p> 
		
					<p>&nbsp;</p>
			
					<b>Duis feugiat condimentum sem sagittis tincidunt</b>
					<p>Vivamus laoreet turpis sed risus pretium id adipiscing leo eleifend. Duis luctus purus eu leo adipiscing ut
					blandit odio posuere. Suspendisse nec mauris non eros pharetra malesuada. Aenean congue orci non nisi placerat viverra. Cras eu odio vitae ipsum porta dapibus
					id vel augue. Aenean sed nisi purus, non porta elit. Ut vulputate faucibus elit non ullamcorper. Suspendisse potenti. Sed at arcu sit amet orci congue semper.
					Pellentesque mollis imperdiet lacus, in vestibulum dui blandit eu. Suspendisse eu ante ac nisi consequat faucibus vel at justo.</p>
		
					<p>&nbsp;</p>
			
					<p>Aenean sollicitudin orci sit amet odio vulputate scelerisque. Phasellus quis felis et justo scelerisque rutrum vitae vel ligula. Cum sociis natoque penatibus et
					magnis dis parturient montes, nascetur ridiculus mus. Duis ac lobortis tortor. Fusce eget tortor elit. Nunc sagittis lacinia mollis. Nulla dignissim erat id odio
					bibendum scelerisque. Proin dignissim elementum tincidunt. Praesent nisl est, mattis ac commodo sed, facilisis in dui. In vitae metus in erat gravida fringilla eget sed ipsum.</p>
				</body>
			</html>
		; // end CONTRACT
		public static var CONFIRMATION_TEXT:String = 'I have read and agree to the above release and I hereby give permission to obtain all DOT-required drug and/or alcohol test results, consumer information, including employment and driving records, as well as background reports.';
		
		// -=- /MUTABLE PUBLIC VARIABLES -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		
		
		// -=- STATE INFORMATION -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //
		
		public static const STATES:XML = new XML(  
			<states>
				<state><name>Alabama</name>
					<abbreviation>AL</abbreviation></state>
				<state><name>Alaska</name>
					<abbreviation>AK</abbreviation></state>
				<state><name>Arizona</name>
					<abbreviation>AZ</abbreviation></state>
				<state><name>Arkansas</name>
					<abbreviation>AR</abbreviation></state>
				<state><name>California</name>
					<abbreviation>CA</abbreviation></state>
				<state><name>Colorado</name>
					<abbreviation>CO</abbreviation></state>
				<state><name>Connecticut</name>
					<abbreviation>CT</abbreviation></state>
				<state><name>Delaware</name>
					<abbreviation>DE</abbreviation></state>
				<state><name>Florida</name>
					<abbreviation>FL</abbreviation></state>
				<state><name>Georgia</name>
					<abbreviation>GA</abbreviation></state>
				<state><name>Hawaii</name>
					<abbreviation>HI</abbreviation></state>
				<state><name>Idaho</name>
					<abbreviation>ID</abbreviation></state>
				<state><name>Illinois</name>
					<abbreviation>IL</abbreviation></state>
				<state><name>Indiana</name>
					<abbreviation>IN</abbreviation></state>
				<state><name>Iowa</name>
					<abbreviation>IA</abbreviation></state>
				<state><name>Kansas</name>
					<abbreviation>KS</abbreviation></state>
				<state><name>Kentucky</name>
					<abbreviation>KY</abbreviation></state>
				<state><name>Louisiana</name>
					<abbreviation>LA</abbreviation></state>
				<state><name>Maine</name>
					<abbreviation>ME</abbreviation></state>
				<state><name>Maryland</name>
					<abbreviation>MD</abbreviation></state>
				<state><name>Massachusetts</name>
					<abbreviation>MA</abbreviation></state>
				<state><name>Michigan</name>
					<abbreviation>MI</abbreviation></state>
				<state><name>Minnesota</name>
					<abbreviation>MN</abbreviation></state>
				<state><name>Mississippi</name>
					<abbreviation>MS</abbreviation></state>
				<state><name>Missouri</name>
					<abbreviation>MO</abbreviation></state>
				<state><name>Montana</name>
					<abbreviation>MT</abbreviation></state>
				<state><name>Nebraska</name>
					<abbreviation>NE</abbreviation></state>
				<state><name>Nevada</name>
					<abbreviation>NV</abbreviation></state>
				<state><name>New Hampshire</name>
					<abbreviation>NH</abbreviation></state>
				<state><name>New Jersey</name>
					<abbreviation>NJ</abbreviation></state>
				<state><name>New Mexico</name>
					<abbreviation>NM</abbreviation></state>
				<state><name>New York</name>
					<abbreviation>NY</abbreviation></state>
				<state><name>North Carolina</name>
					<abbreviation>NC</abbreviation></state>
				<state><name>North Dakota</name>
					<abbreviation>ND</abbreviation></state>
				<state><name>Ohio</name>
					<abbreviation>OH</abbreviation></state>
				<state><name>Oklahoma</name>
					<abbreviation>OK</abbreviation></state>
				<state><name>Oregon</name>
					<abbreviation>OR</abbreviation></state>
				<state><name>Pennsylvania</name>
					<abbreviation>PA</abbreviation></state>
				<state><name>Rhode Island</name>
					<abbreviation>RI</abbreviation></state>
				<state><name>South Carolina</name>
					<abbreviation>SC</abbreviation></state>
				<state><name>South Dakota</name>
					<abbreviation>SD</abbreviation></state>
				<state><name>Tennessee</name>
					<abbreviation>TN</abbreviation></state>
				<state><name>Texas</name>
					<abbreviation>TX</abbreviation></state>
				<state><name>Utah</name>
					<abbreviation>UT</abbreviation></state>
				<state><name>Vermont</name>
					<abbreviation>VT</abbreviation></state>
				<state><name>Virginia</name>
					<abbreviation>VA</abbreviation></state>
				<state><name>Washington</name>
					<abbreviation>WA</abbreviation></state>
				<state><name>West Virginia</name>
					<abbreviation>WV</abbreviation></state>
				<state><name>Wisconsin</name>
					<abbreviation>WI</abbreviation></state>
				<state><name>Wyoming</name>
					<abbreviation>WY</abbreviation></state>
				<state><name>American Samoa</name>
					<abbreviation>AS</abbreviation></state>
				<state><name>District of Columbia</name>
					<abbreviation>DC</abbreviation></state>
				<state><name>Federated States of Micronesia</name>
					<abbreviation>FM</abbreviation></state>
				<state><name>Guam</name>
					<abbreviation>GU</abbreviation></state>
				<state><name>Marshall Islands</name>
					<abbreviation>MH</abbreviation></state>
				<state><name>Northern Mariana Islands</name>
					<abbreviation>MP</abbreviation></state>
				<state><name>Palau</name>
					<abbreviation>PW</abbreviation></state>
				<state><name>Puerto Rico</name>
					<abbreviation>PR</abbreviation></state>
				<state><name>Virgin Islands</name>
					<abbreviation>VI</abbreviation></state>
				<state><name>Armed Forces Africa</name>
					<abbreviation>AE</abbreviation></state>
				<state><name>Armed Forces Americas</name>
					<abbreviation>AA</abbreviation></state>
				<state><name>Armed Forces Canada</name>
					<abbreviation>AE</abbreviation></state>
				<state><name>Armed Forces Europe</name>
					<abbreviation>AE</abbreviation></state>
				<state><name>Armed Forces Middle East</name>
					<abbreviation>AE</abbreviation></state>
				<state><name>Armed Forces Pacific</name>
					<abbreviation>AP</abbreviation></state>
			</states>
		);
		// -=- / STATE INFORMATION -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

		
	} // public final class DSUConfig
} // package