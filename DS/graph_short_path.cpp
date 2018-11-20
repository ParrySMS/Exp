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
			if(mx[i][j]!=0&&mx[i][j]!=MaxDist) {
				this->mx[i][j] = mx[i][j];
			}
		}
	}

}



void Graph::
shortestDij(int v0) { //迪克拉杰斯算法
	int i,j,v,w,min;
	int *dist = new int[node_num];
	bool *final = new bool[node_num];

	int path[MaxLen][MaxLen];//v0--->other short path
	int len[MaxLen];//path node len

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

		if(i==v0) {
			len[i] = 0;
			continue;
		}

		if(mx[v0][i] != MaxDist) {//can go
			path[i][0] = i;
		//	len[i] = 2;
		}

	}

	//start found other
	dist[v0] = 0;
	final[v0] = true;

	for(i=0; i<node_num; i++) {
		cout<<"i:"<<i<<endl;
		cout<<"D: ";
		for(w=0; w<node_num; w++) {
			cout<<dist[w]<<" ";
		}
		cout<<endl;

		min = MaxDist;
		//find near min node
		for(w=0; w<node_num; w++) {
			if(!final[w] && dist[w]>0 && dist[w]<min) { //find min and not add one
				v = w;
				min = dist[w]; //consider to min, ready to add it
			}
		}

		final[v] = true;//add
		cout<<"choose node "<<v<<endl;

		for(w=0; w<node_num; w++) {//update data
			if(!final[w] && min + mx[v][w] < dist[w]) {
				dist[w] = min + mx[v][w];
				cout<<"update:D["<<w<<"]"<<	dist[w]<<endl;
				//copy path
				for(j=0; j<MaxLen; j++) {
					if( path[v][j] == -1) {
						path[w][j] = w ; //add last node
						break;
					}
					path[w][j] = path[v][j];
				}


			}
		}
	}

	//echo res
	for(i=0; i<node_num; i++) {
		if(i == v0) continue;

		if(dist[i]>0 && dist[i]<MaxDist) {

			cout<<v0<<"-"<<i<<"-"<<dist[i];
			cout<<"----["<<v0;

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


