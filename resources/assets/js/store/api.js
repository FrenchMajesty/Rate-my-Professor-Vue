import axios from 'axios';

const BASE_URL= 'http://localhost/ratemy/api';

export function loadAllProfessorsData() {
	return axios.get(`${BASE_URL}/prof/fetch`);
}

export function loadAllSchoolsData() {
	return axios.get(`${BASE_URL}/school/fetch`);
}

export function submitStudentRegistration(data) {
	return axios.post(`${BASE_URL}/signup/student`, data);
}

export function submitLogin(data) {
	return axios.post(`${BASE_URL}/login`, data);
}

export function loadUserData(accessToken) {
	return axios.get(`${BASE_URL}/user`, {headers: {
		Authorization: `Bearer ${accessToken}`
	}});
} 

export function submitLogout(accessToken) {
	return axios.post(`${BASE_URL}/logout`,null, {headers: {
		Authorization: `Bearer ${accessToken}`
	}});
}