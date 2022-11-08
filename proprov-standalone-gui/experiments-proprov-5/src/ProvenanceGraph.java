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
import java.util.ArrayList;
import java.util.List;

public class ProvenanceGraph {
	
	private List<Vertex> vertices;
	private List<Edge> edges;
	
	public ProvenanceGraph(List<Vertex> vertices, List<Edge> edges) {
		this.vertices = vertices;
		this.edges = edges;
	}
	
	public ProvenanceGraph() {
		vertices = new ArrayList<>();
		edges = new ArrayList<>();
	}
	
	public void addVertex(String name, String type) {
		vertices.add(new Vertex(name,type));
	}
	
	public void addEdge(String src, String relation, String dst) {
		edges.add(new Edge(src, relation, dst));
	}
	
	public List<Vertex> getVertices(){
		return vertices;
	}
	
	public List<Edge> getEdges(){
		return edges;
	}
	
	public boolean containsEdge(Edge e) {
		for(Edge edge: edges) {
			if(e.getSrc().equals(edge.getSrc()) && e.getRelation().equals(edge.getRelation())
					&& e.getDst().equals(edge.getDst())) {
				return true;
			}
		}
		return false;
	}

}
