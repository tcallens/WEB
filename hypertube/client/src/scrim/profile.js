import React, { Component } from "react";
import { Tabs, Tab, Button, Image} from "react-bootstrap";

import './css/profile.css'

import Img_pro from './medias/profile.jpg';

export default class Profile extends Component {

	constructor(props) {
		super(props);
		
	}

	render() {
		return (
			<div className="p_main">
				<div className="p_cont1">
					<div className="p_cont1_up">
						<Image className="p_cont1_img" src={Img_pro} roundedCircle />
						<div className="p_cont1_b">
							<h2 style={{color:'#B9B9B9', margin:'0 auto 0 auto', fontSize: '4vw'}}>[MTLK]<span style={{color:'#fff', marginLeft:'5px'}}>PADOX</span></h2>
							<h6 style={{margin: '0 auto 0 auto', letterSpacing:'2px', fontSize:'1.3vw'}}>Team: <span style={{color: '#00D81A'}}>Metaleak</span></h6>
						</div>
					</div>
				</div>
				<div className="p_cont2">
				</div>
				<div>
				</div>
			</div>
		);
	}
}
