<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\ConfigEspecialidades;

class ConfigEspecialidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('config_especialidades')->delete();

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Bachata',
	      'descripcion' => 'Es un género musical bailable originario de la República Dominicana, dentro de lo que se denomina folclore urbano. Está considerado como un derivado del bolero rítmico, influenciado por otros estilos como el son cubano y el merengue.',
	    ));


	    ConfigEspecialidades::create(array(
	      'nombre' => 'Ballet',
	      'descripcion' => 'El Ballet, también conocido como danza clásica, es una danza escénica estilizada que normalmente desarrolla un argumento.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Bolero',
	      'descripcion' => 'El Bolero  es identificable por algunos elementos rítmicos y nuevas formas de composición que aparecieron en el quehacer musical en la isla de Cuba durante el siglo XIX. Aunque comparte el nombre con el bolero español, que es una danza que surgió en siglo XVIII.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Capoeira',
	      'descripcion' => 'Es un arte marcial afro-brasileño que combina facetas de danza, música y acrobacias, así como expresión corporal. Fue desarrollado en Brasil por descendientes africanos con influencias indígenas, probablemente a principios del siglo XVI. Es conocido por sus rápidos y complejos movimiento.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Cumbia',
	      'descripcion' => 'Género musical y danza folclórica tradicional de Colombia, resultado del sincretismo musical de indígenas y negros esclavos en la Costa Caribe durante la Conquista y la Colonia.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Dancehall',
	      'descripcion' => 'Es un género tradicional música popular jamaiquina que se originó hacia finales de los años 1970. Inicialmente, el dancehall era una versión del reggae llena de "espacio", a diferencia del estilo roots, dominante en la escena musical de la isla.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Danza Contemporanea',
	      'descripcion' => 'La danza contemporánea surge como una reacción a las formas clásicas y probablemente como una necesidad de expresarse más libremente con el cuerpo. Es una clase de danza en la que se busca expresar, a través del bailarín , una idea, un sentimiento, una emoción, al igual que el ballet clásico.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Danza Folclórica',
	      'descripcion' => 'El término "danza folclórica" a veces se aplica a determinadas danzas de importancia histórica en la cultura y la historia europea; normalmente se originó antes de siglo XXI.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Danza Nacionalista',
	      'descripcion' => 'Nace de la necesidad de obtener un patrón y una calidad estética que permitan adaptar las danzas populares o folklóricas venezolanas a las exigencias de la escena. Su propósito inmediato fue, pues, la creación de una danza teatral venezolana de aceptación y validez internacional.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Danza Árabe',
	      'descripcion' => 'Es una danza que combina elementos tradicionales de Oriente Medio junto con otros del Norte de África. En árabe se la conoce como rakssharki رقصشرقي ("danza del este" o "danza oriental"). También es denominada en ocasiones como raksbaladi (danza "nacional" o "folk").',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Flamenco',
	      'descripcion' => 'Es un estilo de música y danza propio de Andalucía, Extremadura y Murcia. Sus principales facetas son el cante, el toque y el baile, contando también con sus propias tradiciones y normas. Tal y como lo conocemos hoy en día data del siglo XVIII.',
	    ));

	   	ConfigEspecialidades::create(array(
	      'nombre' => 'Jazz',
	      'descripcion' => 'El jazz es una forma de arte musical que se originó en los Estados Unidos mediante la confrontación de los negros con la música europea. La instrumentación, melodía y armonía del jazz se derivan principalmente de la tradición musical de Occidente.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Kizomba',
	      'descripcion' => 'Es un género musical y un baile que comenzó a componerse entre finales de los años 70 principios de los años 80 en Angola. La kizomba es un género musical de origen angoleño, una ex-colonia portuguesa.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Bailes de Salon',
	      'descripcion' => 'Son aquellos que baila una pareja de forma coordinada y siguiendo el ritmo de la música. En su origen eran meramente lúdicos y populares y su repercusión social fue de tal magnitud que dio lugar a la creación de salas que dotadas de una orquesta y un pavimento adecuado facilitan su práctica.',
	    ));
        
        ConfigEspecialidades::create(array(
	      'nombre' => 'Merengue',
	      'descripcion' => 'El merengue es el baile nacional de la Republica Dominicana. El merengue echó sus raíces en el campo en el siglo XIX, pero ahora su popularidad se ha extendido al través de las clases sociales. Durante todo su historia, era un método para expresar opiniones sociales y políticas.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Ritmos Afrocubanos',
	      'descripcion' => 'Esta categoría reúne a personas naturales de Cuba pertenecientes a la etnia afroamericana (ya sea por línea paterna y/o materna) originarios de África.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Ritmos Tradicionales de Cuba',
	      'descripcion' => 'Entre los ritmos tradicionales del país están Danzón, El son, el mambo, la rumba, el changui, entre otros.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Ritmos Urbanos',
	      'descripcion' => 'El Break Dance , Breaking o Hip-Hop, es una danza urbana que forma parte de la cultura afroamericana surgida en las comunidades de los barrios neoyorquinos como Bronx y Brooklynen los 70. Si bien es cierto que alcanzaría un reconocimiento más alto en la década de los 80.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Salsa Caleña',
	      'descripcion' => 'Cómo el nombre lo dice, este estilo viene de la ciudad colombiana de Cali, la cual es aclamada como la capital mundial de la salsa. Este estilo se reconoce por sus muy rápidos movimientos de piernas y de cadera. Estos rápidos movimientos de piernas son la razón por la qué es tan difícil.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Salsa Casino',
	      'descripcion' => 'La rueda de casino nació en Cuba en la década de los 50, aproximadamente en el año de 1956. Su nombre se debe a que surgió y se bailó por primera vez en el Club Casino Deportivo de ese país.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Salsa en Linea',
	      'descripcion' => 'La salsa en línea representa una forma y una distribución de bailar la salsa. Podemos dividir la salsa en línea en dos estilos diferentes según el tiempo musical On 1 (salsa al uno) o On 2 (salsa al dos).',
	    ));

	   	ConfigEspecialidades::create(array(
	      'nombre' => 'Samba',
	      'descripcion' => 'Es un género musical de raíces africanas surgido en Brasil, del cual deriva un tipo de danza. Es una de las principales manifestaciones de la cultura popular brasileña y un símbolo de la identidad nacional.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Tango',
	      'descripcion' => 'Es un género musical y una danza, característica de la región del Río de la Plata y su zona de influencia, principalmente de las ciudades de Buenos Aires (en Argentina) y Montevideo (en Uruguay).',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Twerking',
	      'descripcion' => 'El perreo es un estilo de baile, en los Estados Unidos se lo conoce también como grinding, twerking, sinónimos también de freak dancing o bootydancing. Puede ser rápido y agresivo o lento.',
	    ));

	    ConfigEspecialidades::create(array(
	      'nombre' => 'Otros',
	      'descripcion' => '',
	    ));

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
