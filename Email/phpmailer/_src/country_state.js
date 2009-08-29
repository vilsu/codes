/*
  Country State Drop Downs v1.1.

  (c) Copyright 2006 by Down Home Consulting, Inc (www.DownHomeConsulting.com)

  Permission is hereby granted, free of charge, to any person obtaining a
  copy of this software and associated documentation files (the "Software"),
  to deal in the Software without restriction, including without limitation
  the rights to use, copy, modify, merge, publish, distribute, sublicense,
  and/or sell copies of the Software, and to permit persons to whom the
  Software is furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included
  in all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
  OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  ITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
  FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
  DEALINGS IN THE SOFTWARE.


  To install, add the following to the top of your page paste the html between the
  form tags from demo2.html or demo.html into your page.

*/

// State table
//
// To edit the list, just delete a line or add a line.  Order is important.  The order
// displayed is the order it appears on the drop down.
//
var state = '\
USA:AK:Alaska|\
USA:AL:Alabama|\
USA:AR:Arkansas|\
USA:AS:American Samoa|\
USA:AZ:Arizona|\
USA:CAN:California|\
USA:CO:Colorado|\
USA:CT:Connecticut|\
USA:DC:D.C.|\
USA:DE:Delaware|\
USA:FL:Florida|\
USA:FM:Micronesia|\
USA:GA:Georgia|\
USA:GU:Guam|\
USA:HI:Hawaii|\
USA:IA:Iowa|\
USA:ID:Idaho|\
USA:IL:Illinois|\
USA:IN:Indiana|\
USA:KS:Kansas|\
USA:KY:Kentucky|\
USA:LA:Louisiana|\
USA:MA:Massachusetts|\
USA:MD:Maryland|\
USA:ME:Maine|\
USA:MH:Marshall Islands|\
USA:MI:Michigan|\
USA:MN:Minnesota|\
USA:MO:Missouri|\
USA:MP:Marianas|\
USA:MS:Mississippi|\
USA:MT:Montana|\
USA:NC:North Carolina|\
USA:ND:North Dakota|\
USA:NE:Nebraska|\
USA:NH:New Hampshire|\
USA:NJ:New Jersey|\
USA:NM:New Mexico|\
USA:NV:Nevada|\
USA:NY:New York|\
USA:OH:Ohio|\
USA:OK:Oklahoma|\
USA:OR:Oregon|\
USA:PA:Pennsylvania|\
USA:PR:Puerto Rico|\
USA:PW:Palau|\
USA:RI:Rhode Island|\
USA:SC:South Carolina|\
USA:SD:South Dakota|\
USA:TN:Tennessee|\
USA:TX:Texas|\
USA:UT:Utah|\
USA:VA:Virginia|\
USA:VI:Virgin Islands|\
USA:VT:Vermont|\
USA:WA:Washington|\
USA:WI:Wisconsin|\
USA:WV:West Virginia|\
USA:WY:Wyoming|\
USA:AA:Military Americas|\
USA:AE:Military Europe/ME/Canada|\
USA:AP:Military Pacific|\
CAN:AB:Alberta|\
CAN:MB:Manitoba|\
CAN:AB:Alberta|\
CAN:BC:British Columbia|\
CAN:MB:Manitoba|\
CAN:NB:New Brunswick|\
CAN:NLD:Newfoundland & Labrador|\
CAN:NS:Nova Scotia|\
CAN:NT:Northwest Territories|\
CAN:NU:Nunavut|\
CAN:ON:Ontario|\
CAN:PE:Prince Edward Island|\
CAN:QC:Quebec|\
CAN:SK:Saskatchewan|\
CAN:YT:Yukon Territory|\
AUS:AAT:Australian Antarctic Territory|\
AUS:ACT:Australian Capital Territory|\
AUS:NT:Northern Territory|\
AUS:NSW:New South Wales|\
AUS:QLD:Queensland|\
AUS:SA:South Australia|\
AUS:TAS:Tasmania|\
AUS:VIC:Victoria|\
AUS:WA:Western Australia|\
BRA:AC:Acre|\
BRA:AL:Alagoas|\
BRA:AM:Amazonas|\
BRA:AP:Amapa|\
BRA:BA:Baia|\
BRA:CE:Ceara|\
BRA:DF:Distrito Federal|\
BRA:ES:Espirito Santo|\
BRA:FN:Fernando de Noronha|\
BRA:GO:Goias|\
BRA:MA:Maranhao|\
BRA:MG:Minas Gerais|\
BRA:MS:Mato Grosso do Sul|\
BRA:MT:Mato Grosso|\
BRA:PA:Para|\
BRA:PB:Paraiba|\
BRA:PE:Pernambuco|\
BRA:PI:Piaui|\
BRA:PR:Parana|\
BRA:RJ:Rio de Janeiro|\
BRA:RN:Rio Grande do Norte|\
BRA:RO:Rondonia|\
BRA:RR:Roraima|\
BRA:RS:Rio Grande do Sul|\
BRA:SC:Santa Catarina|\
BRA:SE:Sergipe|\
BRA:SP:Sao Paulo|\
BRA:TO:Tocatins|\
NLD:DR:Drente|\
NLD:FL:Flevoland|\
NLD:FR:Friesland|\
NLD:GL:Gelderland|\
NLD:GR:Groningen|\
NLD:LB:Limburg|\
NLD:NB:Noord Brabant|\
NLD:NH:Noord Holland|\
NLD:OV:Overijssel|\
NLD:UT:Utrecht|\
NLD:ZH:Zuid Holland|\
NLD:ZL:Zeeland|\
GBR:AVON:Avon|\
GBR:BEDS:Bedfordshire|\
GBR:BERKS:Berkshire|\
GBR:BUCKS:Buckinghamshire|\
GBR:CAMBS:Cambridgeshire|\
GBR:CHESH:Cheshire|\
GBR:CLEVE:Cleveland|\
GBR:CORN:Cornwall|\
GBR:CUMB:Cumbria|\
GBR:DERBY:Derbyshire|\
GBR:DEVON:Devon|\
GBR:DORSET:Dorset|\
GBR:DURHAM:Durham|\
GBR:ESSEX:Essex|\
GBR:GLOUSA:Gloucestershire|\
GBR:GLONDON:Greater London|\
GBR:GMANCH:Greater Manchester|\
GBR:HANTS:Hampshire|\
GBR:HERWOR:Hereford & Worcestershire|\
GBR:HERTS:Hertfordshire|\
GBR:HUMBER:Humberside|\
GBR:IOM:Isle of Man|\
GBR:IOW:Isle of Wight|\
GBR:KENT:Kent|\
GBR:LANCS:Lancashire|\
GBR:LEICS:Leicestershire|\
GBR:LINCS:Lincolnshire|\
GBR:MERSEY:Merseyside|\
GBR:NORF:Norfolk|\
GBR:NHANTS:Northamptonshire|\
GBR:NTHUMB:Northumberland|\
GBR:NOTTS:Nottinghamshire|\
GBR:OXON:Oxfordshire|\
GBR:SHROPS:Shropshire|\
GBR:SOM:Somerset|\
GBR:STAFFS:Staffordshire|\
GBR:SUFF:Suffolk|\
GBR:SURREY:Surrey|\
GBR:SUSS:Sussex|\
GBR:WARKS:Warwickshire|\
GBR:WMID:West Midlands|\
GBR:WILTS:Wiltshire|\
GBR:YORK:Yorkshire|\
IRL:CO ANTRIM:County Antrim|\
IRL:CO ARMAGH:County Armagh|\
IRL:CO DOWN:County Down|\
IRL:CO FERMANAGH:County Fermanagh|\
IRL:CO DERRY:County Londonderry|\
IRL:CO TYRONE:County Tyrone|\
IRL:CO CAVAN:County Cavan|\
IRL:CO DONEGAL:County Donegal|\
IRL:CO MONAGHAN:County Monaghan|\
IRL:CO DUBLIN:County Dublin|\
IRL:CO CARLOW:County Carlow|\
IRL:CO KILDARE:County Kildare|\
IRL:CO KILKENNY:County Kilkenny|\
IRL:CO LAOIS:County Laois|\
IRL:CO LONGFORD:County Longford|\
IRL:CO LOUTH:County Louth|\
IRL:CO MEATH:County Meath|\
IRL:CO OFFALY:County Offaly|\
IRL:CO WESTMEATH:County Westmeath|\
IRL:CO WEXFORD:County Wexford|\
IRL:CO WICKLOW:County Wicklow|\
IRL:CO GALWAY:County Galway|\
IRL:CO MAYO:County Mayo|\
IRL:CO LEITRIM:County Leitrim|\
IRL:CO ROSCOMMON:County Roscommon|\
IRL:CO SLIGO:County Sligo|\
IRL:CO CLARE:County Clare|\
IRL:CO CORK:County Cork|\
IRL:CO KERRY:County Kerry|\
IRL:CO LIMERICK:County Limerick|\
IRL:CO TIPPERARY:County Tipperary|\
IRL:CO WATERFORD:County Waterford|\
';

// Country data table
//
//
// To edit the list, just delete a line or add a line.  Order is important.  The order
// displayed is the order it appears on the drop down.
//
var country = '\
AFG:Afghanistan|\
ALB:Albania|\
DZA:Algeria|\
ASM:American Samoa|\
AND:Andorra|\
AGO:Angola|\
AIA:Anguilla|\
ATA:Antarctica|\
ATG:Antigua and Barbuda|\
ARG:Argentina|\
ARM:Armenia|\
ABW:Aruba|\
AUS:Australia|\
AUT:Austria|\
AZE:Azerbaijan|\
BHS:Bahamas|\
BHR:Bahrain|\
BGD:Bangladesh|\
BRB:Barbados|\
BLR:Belarus|\
BEL:Belgium|\
BLZ:Belize|\
BEN:Benin|\
BMU:Bermuda|\
BTN:Bhutan|\
BOL:Bolivia|\
BIH:Bosnia And Herzegowina|\
BWA:Botswana|\
BVT:Bouvet Island|\
BRA:Brazil|\
IOT:British Indian Ocean Territory|\
BRN:Brunei Darussalam|\
BGR:Bulgaria|\
BFA:Burkina Faso|\
BDI:Burundi|\
KHM:Cambodia|\
CMR:Cameroon|\
CAN:Canada|\
CPV:Cape Verde|\
CYM:Cayman Islands|\
CAF:Central African Republic|\
TCD:Chad|\
CHL:Chile|\
CHN:China|\
CXR:Christmas Island|\
CCK:Cocos (Keeling) Islands|\
COL:Colombia|\
COM:Comoros|\
COG:Congo|\
COK:Cook Islands|\
CRI:Costa Rica|\
CIV:Cote d` Ivoire (Ivory Coast)|\
HRV:Croatia|\
CUB:Cuba|\
CYP:Cyprus|\
CZE:Czech Republic|\
DNK:Denmark|\
DJI:Djibouti|\
DMA:Dominica|\
DOM:Dominican Republic|\
TMP:East Timor|\
ECU:Ecuador|\
EGY:Egypt|\
SLV:El Salvador|\
GNQ:Equatorial Guinea|\
ERI:Eritrea|\
EST:Estonia|\
ETH:Ethiopia|\
FLK:Falkland Islands (Malvinas)|\
FRO:Faroe Islands|\
FJI:Fiji|\
FIN:Finland|\
FRA:France (Includes Monaco)|\
FXX:France, Metropolitan|\
GUF:French Guiana|\
PYF:French Polynesia|\
ATF:French Southern Territories|\
GAB:Gabon|\
GMB:Gambia|\
GEO:Georgia|\
DEU:Germany|\
GHA:Ghana|\
GIB:Gibraltar|\
GRC:Greece|\
GRL:Greenland|\
GRD:Grenada|\
GLP:Guadeloupe|\
GUM:Guam|\
GTM:Guatemala|\
GIN:Guinea|\
GNB:Guinea-Bissau|\
GUY:Guyana|\
HTI:Haiti|\
HMD:Heard And Mc Donald Islands|\
HND:Honduras|\
HKG:Hong Kong|\
HUN:Hungary|\
ISL:Iceland|\
IND:India|\
IDN:Indonesia|\
IRN:Iran|\
IRQ:Iraq|\
IRL:Ireland|\
ISR:Israel|\
ITA:Italy|\
JAM:Jamaica|\
JAP:Japan|\
JOR:Jordan|\
KAZ:Kazakhstan|\
KEN:Kenya|\
KIR:Kiribati|\
PRK:Korea, North|\
KOR:Korea, South|\
KWT:Kuwait|\
KGZ:Kyrgyzstan|\
LAO:Laos|\
LVA:Latvia|\
LBN:Lebanon|\
LSO:Lesotho|\
LBR:Liberia|\
LBY:Libyan Arab Jamahiriya|\
LIE:Liechtenstein|\
LTU:Lithuania|\
LUX:Luxembourg|\
MAC:Macao|\
MKD:Macedonia|\
MDG:Madagascar|\
MWI:Malawi|\
MYS:Malaysia|\
MDV:Maldives|\
MLI:Mali|\
MLT:Malta|\
MHL:Marshall Islands|\
MTQ:Martinique|\
MRT:Mauritania|\
MUS:Mauritius|\
MYT:Mayotte|\
MEX:Mexico|\
FSM:Micronesia|\
MDA:Moldova|\
MCO:Monaco|\
MNG:Mongolia|\
MSR:Montserrat|\
MAR:Morocco|\
MOZ:Mozambique|\
MMR:Myanmar|\
NAM:Namibia|\
NRU:Nauru|\
NPL:Nepal|\
NLD:Netherlands|\
ANT:Netherlands Antilles|\
NCL:New Caledonia|\
NZL:New Zealand|\
NIC:Nicaragua|\
NER:Niger|\
NGA:Nigeria|\
NIU:Niue|\
NFK:Norfolk Island|\
MNP:Northern Mariana Islands|\
NOR:Norway|\
OMN:Oman|\
PAK:Pakistan|\
PLW:Palau|\
PAN:Panama|\
PNG:Papua New Guinea|\
PRY:Paraguay|\
PER:Peru|\
PHL:Philippines|\
PCN:Pitcairn|\
POL:Poland|\
PRT:Portugal|\
PRI:Puerto Rico|\
QAT:Qatar|\
REU:Reunion|\
ROM:Romania|\
RUS:Russian Federation|\
RWA:Rwanda|\
KNA:Saint Kitts And Nevis|\
LCA:Saint Lucia|\
VCT:Saint Vincent and Grenadines|\
WSM:Samoa|\
SMR:San Marino|\
STP:Sao Tome and Principe|\
SAU:Saudi Arabia|\
SEN:Senegal|\
SYC:Seychelles|\
SLE:Sierra Leone|\
SGP:Singapore|\
SVK:Slovakia (Slovak Republic)|\
SVN:Slovenia|\
SLB:Solomon Islands|\
SOM:Somalia|\
ZAF:South Africa|\
SGS:S.Georgia And S.Sandwich Is.|\
ESP:Spain|\
LKA:Sri Lanka|\
SHN:St. Helena|\
SPM:St. Pierre and Miquelon|\
SDN:Sudan|\
SUR:Suriname|\
SJM:Svalbard And Jan Mayen Islands|\
SWZ:Swaziland|\
SWE:Sweden|\
CHE:Switzerland|\
SYR:Syrian Arab Republic|\
TWN:Taiwan|\
TJK:Tajikistan|\
TZA:Tanzania|\
THA:Thailand|\
TGO:Togo|\
TKL:Tokelau|\
TON:Tonga|\
TTO:Trinidad and Tobago|\
TUN:Tunisia|\
TUR:Turkey|\
TKM:Turkmenistan|\
TCA:Turks and Caicos Islands|\
TUV:Tuvalu|\
UGA:Uganda|\
UKR:Ukraine|\
ARE:United Arab Emirates|\
GBR:United Kingdom|\
USA:United States|\
UMI:United States Minor Outlying Isl|\
URY:Uruguay|\
UZB:Uzbekistan|\
VUT:Vanuatu|\
VAT:Vatican (Holy See)|\
VEN:Venezuela|\
VNM:Vietnam|\
VGB:Virgin Islands (British)|\
VIR:Virgin Islands (U.S.)|\
WLF:Wallis and Furuna Islands|\
ESH:Western Sahara|\
YEM:Yemen|\
YUG:Yugoslavia|\
ZAR:Zaire|\
ZMB:Zambia|\
ZWE:Zimbabwe|\
';

// Save the country & state field names
var countryFieldCfgArray = document.getElementById('cs_config_country_field').value.split(' ');
var stateFieldCfgArray   = document.getElementById('cs_config_state_field').value.split(' ');

// Save the names of the fields that hold the country & state default values
var countryDefaultCfgArray = document.getElementById('cs_config_country_default').value.split(' ');
var stateDefaultCfgArray   = document.getElementById('cs_config_state_default').value.split(' ');

var defaultState = false;
var defaultCountry = false;

function TrimString(sInString) {

   if ( sInString ) {

      sInString = sInString.replace( /^\s+/g, "" );// strip leading
      return sInString.replace( /\s+$/g, "" );// strip trailing
   }
}
// Populates the country select with the counties from the country list
//
function populateCountry(idName) {

   var countryLineArray = country.split('|');      // Split into lines

   var selObj = document.getElementById( idName );

   selObj.options[0] = new Option('-- Select --','');
   selObj.selectedIndex = 0;

   for (var loop = 0; loop < countryLineArray.length; loop++) {

      lineArray = countryLineArray[loop].split(':');

      countryCode  = TrimString(lineArray[0]);
      countryName  = TrimString(lineArray[1]);

      if ( countryCode != '' ) {

         selObj.options[loop + 1] = new Option(countryName, countryCode);
      }

      if ( defaultCountry == countryCode ) {

         selObj.selectedIndex = loop + 1;
      }
   }
}
function populateState( statestateIdName, countryIdName ) {

   var selObj = document.getElementById( stateIdName );
   var foundState = false;

   // Empty options just in case new drop down is shorter
   //
   if ( selObj.type == 'select-one' ) {

      selObj.options.length = 0;

      selObj.options[0] = new Option('-- Select --','');
      selObj.selectedIndex = 0;
   }
   // Populate the drop down with states from the selected country
   //
   var stateLineArray   = state.split("|");        // Split into lines

   var optionCntr = 1;

   for (var loop = 0; loop < stateLineArray.length; loop++) {

      lineArray = stateLineArray[loop].split(":");

      countryCode  = TrimString(lineArray[0]);
      stateCode    = TrimString(lineArray[1]);
      stateName    = TrimString(lineArray[2]);

      if ( document.getElementById( countryIdName ).value == countryCode && countryCode != '' ) {

         // If it's a input element, change it to a select
         //
         if ( selObj.type == 'text' ) {

            parentObj = document.getElementById( stateIdName ).parentNode;
            parentObj.removeChild(selObj);

            var inputSel = document.createElement("SELECT");
            inputSel.setAttribute("name","state");
            inputSel.setAttribute("class","state");
            inputSel.setAttribute("id", stateIdName );

            parentObj.appendChild(inputSel) ;

            selObj = document.getElementById( stateIdName );
            selObj.options[0] = new Option('-- Select --','');
            selObj.selectedIndex = 0;
         }

         if ( stateCode != '' ) {

            selObj.options[optionCntr] = new Option(stateName, stateCode);
         }
         // See if it's selected from a previous post
         //
         if ( stateCode == defaultState && countryCode == defaultCountry ) {

            selObj.selectedIndex = optionCntr;
         }
         foundState = true;
         optionCntr++
      }
   }
   // If the country has no states, change the select to a text box
   //
   if ( ! foundState ) {

      parentObj = document.getElementById( stateIdName ).parentNode;
      parentObj.removeChild(selObj);

      // Create the Input Field
      var inputEl = document.createElement("INPUT");

      inputEl.setAttribute("id",  stateIdName );
      inputEl.setAttribute("type", "text");
      inputEl.setAttribute("name", "state");
      inputEl.setAttribute("size", 20);
      inputEl.setAttribute("class", "state");
      inputEl.setAttribute("value", defaultState);
      parentObj.appendChild(inputEl) ;
   }

}
// Called when state drop down is changed
//
function updateState( countryIdNameIn ) {

   for (var loop = 0; loop < countryFieldCfgArray.length; loop++) {

      countryIdName  = countryFieldCfgArray[loop];
      stateIdName    = stateFieldCfgArray[loop];

      // Read the default value hidden fields
      defaultCountry = document.getElementById( countryDefaultCfgArray[loop] ).value;
      defaultState   = document.getElementById( stateDefaultCfgArray[loop] ).value;

      if ( countryIdNameIn == countryIdName ) {

         populateState( stateIdName, countryIdName );
      }
   }
}
// Initialize the drop downs
//
function initCountry() {

   for (var loop = 0; loop < countryFieldCfgArray.length; loop++) {

      countryIdName  = countryFieldCfgArray[loop];
      stateIdName    = stateFieldCfgArray[loop];

      // Read the default value hidden fields
      defaultCountry = document.getElementById( countryDefaultCfgArray[loop] ).value;
      defaultState   = document.getElementById( stateDefaultCfgArray[loop] ).value;

      // populateCountry( countryIdName);
      populateState( stateIdName, countryIdName );
   }
}

