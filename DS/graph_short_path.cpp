#include <iostream>
using namespace std;

const int MaxLen = 20;
const int MaxDist = 9999;

class Graph {
	private:
		int mx[MaxLen][MaxLen];
		int node_num;

	public:
		void mxInit(int node_num,int mx[MaxLen][MaxLen]);
		void shortestDij(int v0);//迪克拉杰斯算法


};

void Graph::
mxInit(int node_num,int mx[MaxLen][MaxLen]) {
	int i,j;
	this->node_num = node_num;
	for(i=0; i<MaxLen; i++) {
		for(j=0; j<MaxLen; j++) {
			this->mx[i][j] = MaxDist;
		}
	}

	for(i=0; i<node_num; i++) {
		for(j=0; j<node_num; j++) {
			if(mx[i][j]!=0) {
				this->mx[i][j] = mx[i][j];
			}
		}
	}

}



void Graph::
shortestDij(int v0) { //迪克拉杰斯算法
	int i,j,v,w,min;
	int *dist = new int[node_num];
	// d[i]  dist about from v0 to other node-i

	bool *final = new bool[node_num];
	//f[i]  node i is visited as final?

	int path[MaxLen][MaxLen];
	//p[i][j]  v0--->vi ,j is id
	// the nodes on shortest path

	//init
	for(i=0; i<node_num; i++) {
		final[i] = false;
		dist[i] = mx[v0][i];
	}
	for(i=0; i<MaxLen; i++) {
		for(j=0; j<MaxLen; j++) {
			path[i][j] = -1;
		}
	}

	for(i=0; i<node_num; i++) {
		if(mx[v0][i] != MaxDist && mx[v0][i] != 0) {//can go
			path[i][0] = i;//one step
		}

	}

	//start found other
	dist[v0] = 0;
	final[v0] = true;

	for(i=0; i<node_num; i++) {
//		cout<<"i:"<<i<<endl;
//		cout<<"D: ";
//		for(w=0; w<node_num; w++) {
//			cout<<dist[w]<<" ";
//		}
//		cout<<endl;

		min = MaxDist;
		//find near min node
		for(w=0,v=v0; w<node_num; w++) {
			if(!final[w] && dist[w]>0 && dist[w]<min) { //find min and not add one
				v = w;
				min = dist[w]; //consider to min, ready to add it
			}
		}

		if(v==v0) {//not found v
//			cout<<"v=v0, conti "<<endl;
			continue;
		}

		final[v] = true;//add
//		cout<<"choose node "<<v<<endl;

		for(w=0; w<node_num; w++) {//update data
			if(!final[w] && mx[v][w]!=0 && min + mx[v][w] < dist[w] ) {
				dist[w] = min + mx[v][w];
//				cout<<"update:D["<<w<<"]"<<	dist[w]<<endl;
				//copy path
				for(j=0; j<node_num; j++) {
					path[w][j] = path[v][j];
				}
				
				//add last node 
				for(j=0; j<node_num; j++) {
					if( path[v][j] == -1) {
						path[w][j] = w ; 
						break;
					}
				}

			}
		}
	}

	//echo res
	for(i=0; i<node_num; i++) {
		if(i == v0) continue;

		if(dist[i]>0 && dist[i]<MaxDist) {

			cout<<v0<<"-"<<i<<"-"<<dist[i];
			cout<<"----["<<v0<<" ";

			for(j=0; j<node_num; j++) {
				if(path[i][j]==-1) {
					break;
				}
				//pass by
				cout<<path[i][j]<<" ";
			}
			cout<<"]"<<endl;
		}
	}

	delete [] dist;
	delete [] final;
}




int main() {
	int i,j,k,t;
	int vnum,v0;
	int mx[MaxLen][MaxLen];
	Graph g;
	cin>>t;
	for(k=0; k<t; k++) {
		//init
		for(i=0; i<MaxLen; i++) {
			for(j=0; j<MaxLen; j++) {
				mx[i][j] = MaxDist;
			}
		}

		cin>>vnum;
		for(i=0; i<vnum; i++) {
			for(j=0; j<vnum; j++) {
				cin>>mx[i][j];
			}
		}
		g.mxInit(vnum,mx);
		cin>>v0;
		g.shortestDij(v0);
	}

	return 0;
}


