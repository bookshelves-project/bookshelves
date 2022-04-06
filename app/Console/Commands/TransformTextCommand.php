<?php

namespace App\Console\Commands;

use App\Services\WikipediaService\WikipediaQuery;
use Illuminate\Console\Command;

class TransformTextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transform:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $text = "<p class=\"mw-empty-elt\">\n</p>\n<p><i><b>La Fille dragon</b></i> (titre original : <i><span lang=\"it\">La ragazza drago</span></i>) est une série de romans de fantasy de Licia Troisi. La série comprend <i>L'Héritage de Thuban</i>, <i>L'Arbre d'Idhunn</i>, <i>Le Sablier d'Aldibah</i>, <i>Les Jumeaux de Kuma</i> et <i>L'Ultime Affrontement</i>.\n</p><p>Elle raconte l'histoire d'une fille orpheline, Sofia, habitée par l'esprit de Thuban, un dragon. Avec ses compagnons, elle cherche à retrouver les fruits de l'arbre monde. L’univers des romans est empreint de mythologie nordique, reprenant et modifiant légèrement de nombreux noms associés à celle-ci comme Nidhogg ou Ratatosk.\n</p>\n\n\n<h2><span id=\"R.C3.A9sum.C3.A9\"></span><span id=\"Résumé\">Résumé</span></h2>\n<p>Une jeune fille, prénommée Sofia, orpheline depuis son plus jeune âge, n'as rien d'ordinaire. Elle subit des moqueries à cause de son grain de beauté au milieu des deux yeux, qui est bizarrement vert. Et puis, un jour, lorsqu'elle était à l'orphelinat, un homme prénommé <abbr class=\"abbr\" title=\"Mister\">Mr</abbr> Schlafen l'adopte. Il lui révèle pourquoi elle a un grain de beauté au milieu du front, et en plus pourquoi il est vert. Il lui explique que Sofia possède, en elle, un dragon. Il lui révèle tout autant la fameuse histoire de Dragonia, cité des dragons, gardiens de l'arbre monde et origine de toutes civilisations. Sofia va devoir rassembler les fruits de cet arbre, à l'aide de plusieurs « enfants dragons ».\n</p>\n<h2><span id=\"Ouvrages\">Ouvrages</span></h2>\n<ol><li><cite class=\"italique\">L'Héritage de Thuban</cite>, Pocket Jeunesse, 2013 (<abbr class=\"abbr indicateur-langue\" title=\"Langue : italien\">(it)</abbr> <cite class=\"italique lang-it\" lang=\"it\">L'eredità di Thuban</cite>, 2008)</li>\n<li><cite class=\"italique\">L'Arbre d'Idhunn</cite>, Pocket Jeunesse, 2013 (<abbr class=\"abbr indicateur-langue\" title=\"Langue : italien\">(it)</abbr> <cite class=\"italique lang-it\" lang=\"it\">L'albero di Idhunn</cite>, 2009)</li>\n<li><cite class=\"italique\">Le Sablier d'Aldibah</cite>, Pocket Jeunesse, 2014 (<abbr class=\"abbr indicateur-langue\" title=\"Langue : italien\">(it)</abbr> <cite class=\"italique lang-it\" lang=\"it\">La clessidra di Aldibah</cite>, 2010)</li>\n<li><cite class=\"italique\">Les Jumeaux de Kuma</cite>, Pocket Jeunesse, 2014 (<abbr class=\"abbr indicateur-langue\" title=\"Langue : italien\">(it)</abbr> <cite class=\"italique lang-it\" lang=\"it\">I gemelli di Kuma</cite>, 2011)</li>\n<li><cite class=\"italique\">L'Ultime Affrontement</cite>, Pocket Jeunesse, 2015 (<abbr class=\"abbr indicateur-langue\" title=\"Langue : italien\">(it)</abbr> <cite class=\"italique lang-it\" lang=\"it\">L'ultima battaglia</cite>, 2012)</li></ol><h2><span id=\"Personnages_principaux\">Personnages principaux</span></h2>\n<dl><dt>Sofia</dt>\n<dd>C'est l'héroïne de cette série, elle est une dormante, en elle vit l'esprit d'un puissant dragon, Thuban. Elle peut créer de la végétation et sa couleur est le vert.</dd></dl><p><br></p>\n<dl><dt>Lidja</dt>\n<dd>Comme Sofia, elle est habitée par l'esprit d'un dragon et partage ses aventures. Elle est habitée par l'esprit de Rastaban. Ses pouvoirs sont le télépathie et la télékinésie, sa couleur est le rouge.</dd></dl><p><br></p>\n<dl><dt>Le professeur</dt>\n<dd>Il adopte Sofia afin de pouvoir retrouver les fruits de l'arbre monde. Il est un gardien.</dd></dl><p><br></p>\n<dl><dt>Nidhoggr</dt>\n<dd>C'est le chef des vouivres et le principal ennemi des dragoniens, et par eux des dragons. Il est retenu dans une prison sous terre mais celle-ci s'affaiblit de jour en jour. Il a plusieurs serviteurs sur terre : Nida et Ratatoskr. Il est le frère de Thuban.</dd></dl><p><br></p>\n<dl><dt>Nida</dt>\n<dd>Vouivre née du sang de Nidhoggr, elle est l'incarnation de sa volonté, cependant, elle lui est soumise et le craint.</dd></dl><p><br></p>\n<dl><dt>Ratatoskr</dt>\n<dd>Comme Nida, il est l'extension de la volonté de Nidhoggr et lui obéit aveuglément.</dd></dl><p><br></p>\n<dl><dt>Fabio</dt>\n<dd>Fabio est un dormant, il a trahi mais est finalement revenu à la raison. Il est habité par l'esprit d'Eltanin. Il peut controler le feu et sa couleur est le rouge.</dd></dl><p><br></p>\n<dl><dt>Chloé et Ewan</dt>\n<dd>Dormants comme les autres dragoniers, ils sont les derniers de la série et ils hébergent tous deux l'esprit de Kuma. Ils peuvent contrôler la météo et leur couleur est le violet.</dd></dl><p><br></p>\n<dl><dt>Karl</dt>\n<dd>Karl est un dormant, il a été adopté très jeune par Effi. Il héberge l'esprit d'Aldibah et peut controler l'eau. Sa couleur est le bleu turquoise.</dd></dl><p><br></p>\n<dl><dt>Effi</dt>\n<dd>Effi comme le professeur et a la recherche des fruits et des dragoniens elle l'a adopter lorsqu'il été bébé et depuis ils sont a la recherche des fruits. Elle est une gardienne.</dd></dl><h2><span id=\"Notes_et_r.C3.A9f.C3.A9rences\"></span><span id=\"Notes_et_références\">Notes et références</span></h2>\n\n<h2><span id=\"Annexes\">Annexes</span></h2>\n<h3><span id=\"Articles_connexes\">Articles connexes</span></h3>\n<ul><li><i>Chroniques du monde émergé</i></li>\n<li>Mythologie nordique</li>\n<li>Alpha Draconis, aussi nommée Thuban, étoile la plus brillante de la constellation du Dragon</li></ul><h3><span id=\"Liens_externes\">Liens externes</span></h3>\n<ul><li><cite class=\"ouvrage\" id=\"site_officiel\" style=\"font-style: normal;\">Site officiel</cite></li></ul>\n<ul id=\"bandeau-portail\" class=\"bandeau-portail\"><li><span><span></span> <span>Portail de la littérature italienne</span> </span></li> <li><span><span></span> <span>Portail de la fantasy et du fantastique</span> </span></li>                   </ul>";

        $content = WikipediaQuery::convertExtract($text, 2000);
        dump($content);

        return 0;
    }
}
