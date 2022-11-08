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
public class EdgePolicy extends Policy {
	private String relation;
	private String srcNode;
	private String dstNode;
	
	public EdgePolicy(String relation, String srcNode, String dstNode) {
		this.relation = relation;
		this.srcNode = srcNode;
		this.dstNode = dstNode;
	}
	
	public EdgePolicy(String relation) {
		this.relation = relation;
		this.srcNode = null;
		this.dstNode = null;
	}
	
	public void setSrc(String node) {
		srcNode = node;
	}
	
	public void setDst(String node) {
		dstNode = node;
	}
	
	public String getRelation() {
		return relation;
	}
	
	public String getSrc() {
		return srcNode;
	}
	
	public String getDst() {
		return dstNode;
	}
	
	@Override
	public String toString() {
		
		if(srcNode == null && dstNode == null) {
			return relation+"(<node>, <node>)";
		}else if(srcNode != null && dstNode == null){
			return relation+"(" + srcNode +", <node>)";
		}else if(srcNode == null && dstNode != null) {
			return relation+"(<node>, " + dstNode+")";
		}
		return relation+"(" + srcNode + "," + dstNode + ")";
	}

	@Override
	public boolean evaluate(ProvenanceGraph graph) {
		
		Edge e = new Edge(srcNode, relation, dstNode);
		if(graph.containsEdge(e)) {
			return true;
		}
		
		return false;
	}

}
