import axios from 'axios';
import store from './store';

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


const auth = () => {
	const {accessToken} = store.state.auth;
	return { headers: { Authorization: `Bearer ${accessToken}` } };
};

export function loadUserData() {
	return axios.get(`${BASE_URL}/user`, auth());
} 

export function submitLogout() {
	return axios.post(`${BASE_URL}/logout`, null, auth());
}