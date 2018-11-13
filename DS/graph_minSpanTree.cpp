#include <iostream>
#include <string>
#include <stack>

#define MAX 9999

using namespace std;

class CloseE {
		int adjvex = -1;
		int lowcost = 0;

		void set(int v,int c) {
			adjvex = v;
			lowcost = c;
		}
};

class Graph {
	private:
		int v_num;
		CloseE * close;//each node's min
	public:
		int **mx;
		string * nodes;
		int node_num,edge_num;

		~Graph() {
			node_num =0;
			delete [] nodes;
			delete [] mx;
			while(!nearNodes.empty()) {
				nearNodes.pop();
			}
		}

		void init(int node_num,string* nodes) {
			//init
			mx = new int* [node_num];
			nodes = new string [node_num]();
			for(i=0; i<node_num; i++) {
				mx[i] = new int [node_num]();
				this->nodes[i] = nodes[i];

			}
			v_num = 0;
			close = new Close[node_num];
		}

		int getIndex(string name) {
			int i;
			for(i=0; i<node_num; i++) {
				if(nodes[i] == name) {
					return i;
				}
			}
			//not found
			return -1;
		}

		void addEdge(string name1,string name2,int cost) {
			addEdge(getIndex(name1),getIndex(name2),int cost);
		}

		void addEdge(int index1,int index2,int cost) {
			if(index1<0 || index2<0) {
				cout<<"ERROR:index invaild"<<endl;
				return;
			}
			//set value
			mx[index2][index1] = cost;
			mx[index1][index2] = cost;
		}

		void prim(string start) {
			prim(getIndex(start));
		}

		void prim(int v) {
			if(v<0) {
				cout<<"ERROR:index invaild"<<endl;
				return;
			}
			
			
			int i,j,lowcost,min_index;
			CloseE* edges = new CloseE[node_num]();
			//one point's all edge

			//getNear
			for(i=0; i<node_num; i++) {
				if(mx[v][i]> 0 ) { //connected
					edges[i]->set(v,mx[v][i]);
				}
			}
			//chooseMin
			for(i=0,lowcost = MAX,min_index = -1; i<node_num; i++) {
				if(edges[i].lowcost>0 && edges[i].lowcost< lowcost) { 
					lowcost = edges[i].lowcost;
					min_index = i;
				}
			}
			
			if(min_index == -1){//end
				//end
			}else{
				cout<<nodes[edges[min_index]->adjvex]<<" ";
				
				edges[min_index]->set(-1,0);
			}

			


		}





};

int main() {
	int i,node_num,edge_num,cost;
	string name1,name2;
	string * nodes;
	Graph* g;

	cin>>node_num;
	nodes = new string[node_num]();

	for(i=0; i<node_num; i++) {
		cin>>nodes[i];
	}


	g = new Graph();
	g->init(node_num,nodes);

	cin>>edge_num;
	for(i=0; i<edge_num; i++) {
		cin>>name1>>name2>>cost;
		g->addEdge(name1,name2,cost);
	}

	cin>>name1;//start point







	return 0;
}
