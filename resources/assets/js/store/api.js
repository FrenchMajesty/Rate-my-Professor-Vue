import axios from 'axios';

const BASE_URL= 'http://localhost/ratemy';

export function loadAllProfessorsData() {
	return axios.get(`${BASE_URL}/api/prof/fetch`);
}