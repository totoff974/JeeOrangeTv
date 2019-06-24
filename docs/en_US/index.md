Description 
===

Plugin permettant d'utiliser votre jeedom comme télécommande de votre
décodeur Orange.

Configuration du plugin 
===

La configuration est pré-configurée pour être fonctionnelle, cependant
vous modifier les éléments suivants :

-   Fréquence d'interrogation des décodeurs (en secondes)

-   Affichage sous forme de Widget

-   Port socket interne

Fréquence d'interrogation des décodeurs (en secondes)
-----------

Permet de définir l'intervalle en seconde, pour l'interrogation de
l'état du décodeur.
Plus la valeur est basse, plus cela risque de ralentir votre domotique
et votre réseau.

Affichage sous forme de Widget
-----------

Si coché, le plugin sera affiché avec les images de la télécommande.
Si non coché, alors les boutons classiques seront affichés.

Port socket interne
-----------

Permet de définir le port du socket pour communiquer avec le script
python. A ne modifier que si le port est déjà utilisé.

Configuration des équipements
===

Permet de configurer votre décodeur. Plusieurs décodeurs peuvent être
créés.

Adresse IP du Décodeur
-----------

Adresse du décodeur sur votre réseau. Obligatoire pour que le plugin
fonctionne. Pour connaitre l'ip de votre décodeur utilisez l'interface
de votre livebox (192.168.1.1).

Localisation géographique
-----------

A choisir afin d'avoir les bons canaux en fonction des chaînes.
Suivant votre localisation la numérotation peux changer.

Mosaïque
-----------

Vous pouvez définir 24 raccourcis vers vos chaines favorites.
A sélection dans la liste déroulante du panneau Mosaïque.