<map version="freeplane 1.5.9">
<!--To view this file, download free mind mapping software Freeplane from http://freeplane.sourceforge.net -->
<node TEXT="Progetto&#xa;Spiagge" FOLDED="false" ID="ID_529752297" CREATED="1481377950212" MODIFIED="1481379736760" STYLE="oval">
<font SIZE="10"/>
<hook NAME="MapStyle">
    <properties fit_to_viewport="false;"/>

<map_styles>
<stylenode LOCALIZED_TEXT="styles.root_node" STYLE="oval" UNIFORM_SHAPE="true" VGAP_QUANTITY="24.0 pt">
<font SIZE="24"/>
<stylenode LOCALIZED_TEXT="styles.predefined" POSITION="right" STYLE="bubble">
<stylenode LOCALIZED_TEXT="default" COLOR="#000000" STYLE="fork">
<font NAME="SansSerif" SIZE="10" BOLD="false" ITALIC="false"/>
</stylenode>
<stylenode LOCALIZED_TEXT="defaultstyle.details"/>
<stylenode LOCALIZED_TEXT="defaultstyle.attributes">
<font SIZE="9"/>
</stylenode>
<stylenode LOCALIZED_TEXT="defaultstyle.note" COLOR="#000000" BACKGROUND_COLOR="#ffffff" TEXT_ALIGN="LEFT"/>
<stylenode LOCALIZED_TEXT="defaultstyle.floating">
<edge STYLE="hide_edge"/>
<cloud COLOR="#f0f0f0" SHAPE="ROUND_RECT"/>
</stylenode>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.user-defined" POSITION="right" STYLE="bubble">
<stylenode LOCALIZED_TEXT="styles.topic" COLOR="#18898b" STYLE="fork">
<font NAME="Liberation Sans" SIZE="10" BOLD="true"/>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.subtopic" COLOR="#cc3300" STYLE="fork">
<font NAME="Liberation Sans" SIZE="10" BOLD="true"/>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.subsubtopic" COLOR="#669900">
<font NAME="Liberation Sans" SIZE="10" BOLD="true"/>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.important">
<icon BUILTIN="yes"/>
</stylenode>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.AutomaticLayout" POSITION="right" STYLE="bubble">
<stylenode LOCALIZED_TEXT="AutomaticLayout.level.root" COLOR="#000000" STYLE="oval" SHAPE_HORIZONTAL_MARGIN="10.0 pt" SHAPE_VERTICAL_MARGIN="10.0 pt">
<font SIZE="18"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,1" COLOR="#0033ff">
<font SIZE="16"/>
<edge COLOR="#ff0000"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,2" COLOR="#00b439">
<font SIZE="14"/>
<edge COLOR="#0000ff"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,3" COLOR="#990000">
<font SIZE="12"/>
<edge COLOR="#00ff00"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,4" COLOR="#111111">
<font SIZE="10"/>
<edge COLOR="#ff00ff"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,5">
<edge COLOR="#00ffff"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,6">
<edge COLOR="#7c0000"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,7">
<edge COLOR="#00007c"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,8">
<edge COLOR="#007c00"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,9">
<edge COLOR="#7c007c"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,10">
<edge COLOR="#007c7c"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,11">
<edge COLOR="#7c7c00"/>
</stylenode>
</stylenode>
</stylenode>
</map_styles>
</hook>
<hook NAME="AutomaticEdgeColor" COUNTER="8" RULE="ON_BRANCH_CREATION"/>
<node TEXT="Mappa" POSITION="right" ID="ID_541999088" CREATED="1481378113947" MODIFIED="1481379469115" HGAP_QUANTITY="19.24999984353781 pt" VSHIFT_QUANTITY="-90.74999729543933 pt">
<edge COLOR="#0000ff"/>
<node TEXT="Griglia con coordinate X/Y" ID="ID_891165311" CREATED="1481378139171" MODIFIED="1481378159149"/>
<node TEXT="Ci possono essere buchi" ID="ID_715729537" CREATED="1481378170915" MODIFIED="1481378189693"/>
<node TEXT="Ogni griglia ha un proprio codice identificativo univoco per owner" ID="ID_1041436755" CREATED="1481378249593" MODIFIED="1481378649588"/>
<node TEXT="Possono esistere pi&#xf9; griglie per lo stesso owner" ID="ID_1977629778" CREATED="1481378286819" MODIFIED="1481378310990"/>
<node TEXT="Editor visuale con icone per delimitare spiaggia e posizionare attrezzature" ID="ID_889080837" CREATED="1481378191646" MODIFIED="1481379177111" HGAP_QUANTITY="13.25000002235174 pt" VSHIFT_QUANTITY="6.749999798834327 pt"/>
<node TEXT="Definita dall&apos;owner" ID="ID_1694439162" CREATED="1481379179561" MODIFIED="1481379208717" HGAP_QUANTITY="16.249999932944778 pt" VSHIFT_QUANTITY="-6.749999798834331 pt"/>
<node TEXT="Posizione" ID="ID_1692714071" CREATED="1481378699175" MODIFIED="1481378960070" HGAP_QUANTITY="14.749999977648258 pt" VSHIFT_QUANTITY="17.249999485909953 pt">
<edge COLOR="#00c0ff"/>
<node TEXT="Pi&#xf9; posizioni compongono la griglia" ID="ID_1554494707" CREATED="1481378706003" MODIFIED="1481378714660"/>
<node TEXT="Hanno una disponibilit&#xe0; (occupato/libero)" ID="ID_532370330" CREATED="1481378332906" MODIFIED="1481378730301"/>
<node TEXT="Sono linkate all&apos;affittuario, se presente" ID="ID_1131318858" CREATED="1481378423926" MODIFIED="1481378735973"/>
</node>
</node>
<node TEXT="Owner" POSITION="left" ID="ID_1278707866" CREATED="1481379519101" MODIFIED="1481379526906" HGAP_QUANTITY="16.999999910593036 pt" VSHIFT_QUANTITY="-77.99999767541892 pt">
<edge COLOR="#00ffff"/>
<node TEXT="Definisce la mappa" ID="ID_1697788901" CREATED="1481379746179" MODIFIED="1481379752290"/>
<node TEXT="Definisce le modalit&#xe0; di noleggio" ID="ID_773449588" CREATED="1481379758041" MODIFIED="1481379773590"/>
<node TEXT="Gestione account" ID="ID_303213653" CREATED="1481379786071" MODIFIED="1481379791373"/>
</node>
<node POSITION="right" ID="ID_1800436103" CREATED="1481379529353" MODIFIED="1481379732244" HGAP_QUANTITY="61.99999856948857 pt" VSHIFT_QUANTITY="-50.24999850243334 pt"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      Customer
    </p>
    <ul>
      <li>
        Si registra quando affitta una posizione
      </li>
      <li>
        Pu&#242; cedere il proprio posto quando non lo usa
      </li>
      <li>
        Ne ottiene un credito
      </li>
    </ul>
  </body>
</html>

</richcontent>
<edge COLOR="#7c0000"/>
</node>
<node TEXT="Operator" POSITION="left" ID="ID_650290598" CREATED="1481379544301" MODIFIED="1481379713698" HGAP_QUANTITY="29.749999530613437 pt" VSHIFT_QUANTITY="8.249999754130847 pt">
<edge COLOR="#00007c"/>
<node TEXT="Occupa / libera posizioni" ID="ID_1665579183" CREATED="1481379670359" MODIFIED="1481379688873"/>
<node TEXT="Occupa / libera attrezzature" ID="ID_8114076" CREATED="1481379693558" MODIFIED="1481379703483"/>
</node>
<node TEXT="Servizi" POSITION="right" ID="ID_234563125" CREATED="1481379721454" MODIFIED="1481379736759" HGAP_QUANTITY="8.750000156462189 pt" VSHIFT_QUANTITY="15.749999530613437 pt">
<edge COLOR="#007c00"/>
</node>
</node>
</map>
