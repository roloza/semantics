const CryptoJS = require("crypto-js");
const toastr = require("toastr");

let form = document.querySelector('#home-analyse-form');
let submit = document.querySelector('#btn-submit');
let url = document.querySelector('#url');

if (form != null) {
	submit.addEventListener('click', function (e) {
		const dataUser = form.dataset.user;
		if (url.value === '') {
			toastr.error('Veuillez entrer une url à analyse')
			return false;
		} else if (!isValidHttpUrl(url.value)) {
			toastr.error('Le format de l\'url est invalide')
			return false;
		}
		else if (dataUser === '') {
			toastr.error('Veuillez vous connecter pour lancer cette analyse')
			return false;
		}
		runJob(dataUser);
	});
}

window.decrypt = (encrypted) => {
	const key = process.env.MIX_APP_KEY.substr(7);
	var encrypted_json = JSON.parse(atob(encrypted));
	return CryptoJS.AES.decrypt(
		encrypted_json.value,
		CryptoJS.enc.Base64.parse(key),
		{
			iv : CryptoJS.enc.Base64.parse(encrypted_json.iv)
		}
	).toString(CryptoJS.enc.Utf8)
};

let userToJson = function (user) {
	user = user.substr(7)
	user = user.substring(0, user.length - 2);
	return JSON.parse(user);
}

let runJob = function(dataUser) {
	let user = userToJson(decrypt(dataUser));
	
	const params = new URLSearchParams({
		url: url.value,
		type: 'page',
		typeContent: 'all',
		userId: user.id
	}).toString();
	
	axios.post(form.dataset.route + '?' + params)
	.then(function (response) {
		if (response.data.message === 'success') {
			if (response.data.uuid) {
				let isRunning = true;
				let i = 0;
				
				(async (qualifiedName, value) => {
					document.getElementById('home-analyse-loader').classList.remove('hidden')
					document.getElementById('btn-submit').setAttribute("disabled", "disabled");
					document.getElementById('btn-submit').classList.add("btn-dark");
					
					let jobResponse = null;
					// Tant que la tache est running
					while (isRunning && i < 20) {
						i++;
						axios.get(form.dataset.route + '/' + response.data.uuid)
							.then(function (response) {
								if (response.data.status_id === 3) {
									isRunning = false;
									window.location.href = form.dataset.routeanalyse + response.data.uuid
								} if (response.data.status_id === 4) {
									isRunning = false;
								}
								jobResponse = response;
							}).catch(function (err) {
								// On ne fait rien pour l'instant
						})
						await sleep(500);
					}
					
					if (jobResponse.data.status_id == 4) {
						toastr.error(jobResponse.data.status.name + ' : ' + jobResponse.data.message)
					}
					
					document.getElementById('home-analyse-loader').classList.add('hidden');
					document.getElementById('btn-submit').removeAttribute("disabled");
					document.getElementById('btn-submit').classList.remove("btn-dark");
				})();
				
				
			}
		
		// Cas plusieurs traitement simultanés
		} else {
			toastr.error("Un traitement est déja en cours. Veuillez attendre qu'il se termine pour en lancer un nouveau");
		}
		
	})
	.catch(function (err) {
		toastr.error("Une erreur est survenue");
	})

}

let sleep = function(time) {
	return new Promise((resolve) => setTimeout(resolve, time));
}


var isValidHttpUrl = function (string) {
	let url;
	
	try {
		url = new URL(string);
	} catch (_) {
		return false;
	}
	
	return url.protocol === "http:" || url.protocol === "https:";
}