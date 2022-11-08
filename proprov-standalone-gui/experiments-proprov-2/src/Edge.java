/*
* DISTRIBUTION STATEMENT A. Approved for public release. Distribution is unlimited.
* This material is based upon work supported by the Under Secretary of Defense for Research and Engineering 
* under Air Force Contract No. FA8702-15-D-0001. Any opinions, findings, conclusions or recommendations 
* expressed in this material are those of the author(s) and do not necessarily reflect the views of the 
* Under Secretary of Defense for Research and Engineering.
* 
* © 2021 Massachusetts Institute of Technology.
* 
* The software/firmware is provided to you on an As-Is basis
* Delivered to the U.S. Government with Unlimited Rights, as defined in DFARS Part 252.227-7013 or 
* 7014 (Feb 2014). Notwithstanding any copyright notice, U.S. Government rights in this work are defined 
* by DFARS 252.227-7013 or DFARS 252.227-7014 as detailed above. Use of this work other than as specifically 
* authorized by the U.S. Government may violate any copyrights that exist in this work.
* 
* RAMS # 1017050
*/
public class Edge {
	
	private String src;
	private String dst;
	private String relation;
	
	public Edge(String src, String relation, String dst) {
		this.src = src;
		this.relation = relation;
		this.dst = dst;
	}
	
	public String getSrc() {
		return src;
	}
	
	public String getRelation() {
		return relation;
	}
	
	public String getDst() {
		return dst;
	}
	
	public boolean equals(Edge e) {
		if(e.getSrc().equals(src) && e.getDst().equals(dst) && e.getRelation().equals(relation)) {
			return true;
		}
		return false;
	}

}
