
/***** Contenu de test *****/

function loadTestContent()
{
	clearResponesWindow();
	addResponseWindow({ 
	    title: 'Test des images', 
	    text: 'Lorem ipsum dolor si amet.',
	    responseId: 'r1',
	    carousel: Array (
			{
				mediaType: 'image',					
				mediaSrc: 'medias/Reponse1/1.jpg',
				mediaCaption: 'Une libelube',
				mediaThumb: ''
			},
			{
				mediaType: 'image',					
				mediaSrc: 'medias/Reponse1/1_.jpg',
				mediaCaption: 'Kikoo',
				mediaThumb: ''
			}	
	    )
	});
	addResponseWindow({ 
	    title: 'Test des videos', 
	    text: 'Lorem ipsum dolor si amet. Lorem ipsum dolor si amet. Lorem ipsum dolor si amet.',
	    responseId: 'r1',
	    carousel: Array (
			{
				mediaType: 'video',					
				mediaSrc: 'medias/video.flv',
				mediaCaption: 'Fichier FLV',
				mediaThumb: 'medias/Reponse2/1.jpg'
			}			
	    )
	});
	
	addResponseWindow({ 
	    title: 'Test des medias sonores', 
	    text: 'Lorem ipsum dolor si amet.',
	    responseId: 'r1',
	    carousel: Array (
			{
				mediaType: 'sound',					
				mediaSrc: 'medias/Britney Spears - Toxic.mp3',
				mediaCaption: 'Fichier MP3',
				mediaThumb: ''
			},
			{
				mediaType: 'sound',					
				mediaSrc: 'medias/In Motion.ogg',
				mediaCaption: 'Fichier OGG',
				mediaThumb: 'medias/Reponse2/1.jpg'
			}	
	    )
	});		

	addBreadcrumbElement('Plup 0', 'Jizag pil fidpoz gilak ?', 'q1');
	clearBreadcrumb();
	addBreadcrumbElement('Question ', 'Combien l\'insecte a t-il de pattes ?', 'q1');
	addBreadcrumbElement('Question ', 'Que voyez-vous ?', 'q2');

	setQuestionText('Que voyez-vous ?', 'Vous devez nous dire ce que vous avez vue.');

	setInformationsWindow(
		Array (
			{
				mediaType: 'image',					
				mediaSrc: 'medias/Question/1.jpg',
				mediaCaption: 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non.',
				mediaThumb: ''
			},
			{
				mediaType: 'image',					
				mediaSrc: 'medias/Question/2.jpg',
				mediaCaption: 'Gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.',
				mediaThumb: ''
			},
			{
				mediaType: 'video',					
				mediaSrc: 'medias/video.flv',
				mediaCaption: 'Fichier FLV',
				mediaThumb: 'medias/Reponse2/1.jpg'
			},
			{
				mediaType: 'sound',					
				mediaSrc: 'medias/In Motion.ogg',
				mediaCaption: 'Fichier OGG',
				mediaThumb: 'medias/Reponse2/1.jpg'
			}
	    )
	);
}
