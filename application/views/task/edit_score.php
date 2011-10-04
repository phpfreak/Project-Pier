<div id="Header" class="global">
    <h1>ASSESSOR PANEL</h1>
</div>
 
<div id="Wrapper">
<div id="content" class="container">
<div id="msg_satus"></div>
	
 
<div class="Full">
	<div class="col">
		<div class="page_header">
		<!-- Debut Header colone Full -->
			<div class="page_header_links">
			  			  <strong>Scoring</strong> |
			  <a href="affectListCrSubGap.php?act=list&id_ass=1&id_cass=1&id_acass=68">Feedback</a>
			  			</div>
			<h1>
				RADAR Scoring Matrix
			</h1>
		<!-- Fin Header colone Full -->
		</div>
		<div class="innercol">
		<!-- Debut Zone de donnee Colone Full -->
			<div class="zone1">	
				<img src="includes/images/back_f2.png" alt="logo"/><br/><a href="listSessions.php">Back to Sessions list</a>
			</div>
 
			<div class="zone2">
				
				<div class="innerinfosession">
					<select id="id_criteria" name="id_criteria" class="inputbox" size="1" onChange="goGetRecapScore(1,1,68 );VideScore();setCriteriaTxt('criteria');getSubCriteria(1,1,68)">
						<option value="">-- Choose Criteria --</option>										
						<option value="1">Leadership</option><option value="2">Strategy</option><option value="3">People</option><option value="4">Partnerships & Resources</option><option value="5">Processes, Products & Services</option><option value="6">Customer Results</option><option value="7">People Results</option><option value="8">Society Results</option><option value="9">Key Results</option>					</select>
 
					<br/><br/>
					
					<span id="option_subcriteria">
										<select id="id_sub_criteria" name="id_sub_criteria" class="inputbox" size="1" onChange="VideRecapScore();setCriteriaTxt('subcriteria');goGetForScoring(1,1,68);matchingsas(1,1,68);matchinggaps(1,1,68);">
											<option value="">-- Choose Part --</option>										
											</select>
					</span>
					
					<br/><br/>
					
					<span id="crt" class="nameCrSCr grasrouge"></span><span id="scrt" class="nameCrSCr grasrouge"></span>
				</div>
 
			</div>
			
			
			<div class="zone3">
				<div class="innerinfosession">
					<strong>Session name:</strong> RGP All dep v4 <br/>
					<strong>Company:</strong> Granin Consulting <br/>
					<strong>Target date:</strong> 2010-03-28 <br/>
					<strong>Lead assessor:</strong> Lillian ak1 <br/>
					<strong>Company contact:</strong> Chris <br/>
					<strong>Type:</strong> External <br/>
					<strong>Status:</strong> Submitted				</div>
 
				<div class="LogoBox">
						<img class="logo" src="includes/images/logo/granin.jpg"  alt="logo"/>
				</div>
			</div>
 
			
			<div style="clear: both;">&nbsp;</div>
			
			<div class="datashow">
				<h1>					
				</h1>
 
				<span id="matching_sas"></span>
								
				<div style="clear: both;">&nbsp;</div>
				
				<span id="radar_recap_score">
					<table class="tablenote">
						<tr>
							<th class="attributes">Criterion \ Part</td>
							<th>a</td>
							<th>b</td>
							<th>c</td>
							<th>d</td>
							<th>e</td>
							<th>Total</td>	
						</tr>
						<tr>								
							<td class="attributes">Leadership</td>
							<td>4.44</td>
							<td>47.5</td>
							<td>63.61</td>
							<td>44.72</td>
							<td>71.94</td>	
							<td><span class="total"><b>46.44</b></span></td>		
						</tr>
						<tr>
							<td class="attributes">Strategy</td>
							<td>78.61</td>
							<td>52.78</td>
							<td>61.67</td>
							<td>40</td>
							<td class="desactivated">&nbsp;</td>
							<td><span class="total"><b>58.26</b></span></td>
						 </tr>
						<tr>
							<td class="attributes">People</td>
							<td>63.61</td>
							<td>67.22</td>
							<td>62.78</td>
							<td>60</td>
							<td>63.06</td>	
							<td><span class="total"><b>63.33</b></span></td>		
						</tr>
						<tr>
							<td class="attributes">Partnership & Resources</td>
							<td>57.78</td>
							<td>64.44</td>
							<td>59.17</td>
							<td>57.78</td>
							<td>73.06</td>	
							<td><span class="total"><b>62.44</b></span></td>
						</tr>  
						<tr>
							<td class="attributes">Processes, Products & Services</td>
							<td>64.17</td>
							<td>73.61</td>
							<td>73.61</td>
							<td>60.28</td>
							<td>83.06</td>	
							<td><span class="total"><b>70.94</b></span></td>	
						</tr>
						<tr>
							<td class="attributes">Customer Results</td>
							<td>52.71</td>
							<td>52.5</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td><span class="total"><b>52.66</b></span></td>
						</tr>  
						<tr>
							<td class="attributes">People Results</td>
							<td>57.08</td>
							<td>71.88</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td><span class="total"><b>60.78</b></span></td>	
						</tr> 
						<tr>
							<td class="attributes">Society Results</td>
							<td>2.29</td>
							<td>13.96</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td><span class="total"><b>8.13</b></span></td>	
						</tr> 
						<tr>
							<td class="attributes">Key Results</td>
							<td>70.83</td>
							<td>58.33</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td class="desactivated">&nbsp;</td>
							<td><span class="total"><b>64.58</b></span></td>	
						</tr>   
					</table>
 
					<br/>
 
					<table class="tablenote">
					  <tr class="overalltotal">
						<td width="250"><strong>Overall Total</strong></td>
						<td class="overalltotal">546.2</td>
					  </tr>
					</table>	
					
					<div style="clear: both;">&nbsp;</div>	
									
					<div style="clear: both;">&nbsp;</div>	
					<div align="center"><img src="graph_radar.php?id_acass=68" alt="RADAR Scoring Matrix " width="900" height="500" /></div>
					
				</span>
					
				<span id="scoring"></span>
				
				<span id="matching_gaps"></span>
 
			</div>
		<!-- Fin Zone de donnee Colone Full -->
		</div>
	</div>
	<div class="bottom">&nbsp;</div>
</div>
 
    </div>
</div>

</div>