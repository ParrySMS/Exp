#include <iostream>
#include <string>

#define MAX 9999
using namespace std;

class CloseE {
	public:
		int vi;
		int vo;
		int lowcost;

		CloseE() {
			vi = -1;
			vo = -1;
			lowcost = 9999;
		}


		void set(int vi,int vo ,int c) {
			this->vi = vi;
			this->vo = vo;
			lowcost = c;
		}
};

class Graph {
	private:
		int v_num;

	public:
		int **mx;
		string * nodes;

		int node_num,edge_num;

		Graph() {
			node_num = 0;

		}

		~Graph() {
			node_num = 0;

//			delete [] nodes;
//			delete [] mx;

		}


		void init(int node_num,string* nodes) {
			int i;
			//init
			this->mx = new int* [node_num];
			this->nodes = new string [node_num];
			this->node_num = node_num;

			for(i=0; i<node_num; i++) {
				this->mx[i] = new int [node_num]();
				this->nodes[i] = nodes[i];

			}
			this->v_num = 0;

		}

		void echoMx() {
			int i,j;
			for(i=0; i<node_num; i++) {
				for(j=0; j<node_num; j++) {
					cout<<mx[i][j]<<" ";
				}
				cout<<endl;
			}
		}

		int getIndex(string name) {
			int i;
			for(i=0; i< this->node_num; i++) {

				if( this->nodes[i].compare(name) == 0) {
					return i;
				}
			}
//			not found
//			return -1;
		}

		void addEdge(string name1,string name2,int cost) {
			int index1 = getIndex(name1);
			int index2 = getIndex(name2);
			//	cout<<index1<<"  "<<index2;
			this->addEdge(index1,index2,cost);
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

			int* visit = new int [this->node_num]();
			CloseE** close = new CloseE*[this->node_num];
			CloseE* e;
			int i,j,t,visited_num = 1;
			int sum = 0;
			int min = MAX;

			visit[v] = 1;

//			cout<<"start while"<<endl;
//			cout<<this->node_num<<endl;

			for(visited_num=1; visited_num< this->node_num; visited_num++) {


				e = new CloseE();
				//for all outside node
				for(i=0; i< this->node_num; i++) { //not visited node
					if(visit[i] == 1) {
						continue;
					}

					min = MAX;
//					cout<<"vaild i not visit []"<<i<<endl;

					for(j=0; j< this->node_num; j++) { //visited node
						if(visit[j] != 1) {
							continue;
						}
//						cout<<"vaild j visit []"<<j<<endl;
						//not connected
						if( this->mx[i][j] == 0) {
							continue;
						}
						//connect
//						cout<<"connected: i "<<i<<" ,j "<<j<<endl;
						min = this->mx[i][j] < min ? this->mx[i][j] : min;

						//get a min edge to a visited node
						if(min < e->lowcost) {
//							cout<<"setLinked: i "<<i<<" ,j "<<j<<endl;
							e->set(j,i,min);
						}

					}//for j

				}//for i

				//add into visited check end
				close[visited_num] = new CloseE();
				close[visited_num]->set(e->vi,e->vo,e->lowcost);
				sum+=e->lowcost;

//				cout<<this->nodes[e->vi]<<" ";
//				cout<<this->nodes[e->vo]<<" ";
//				cout<<close[visited_num]->lowcost<<endl;

				visit[e->vo] = 1;

			}//while


			//echo
			cout<<sum<<endl;
			cout<<"prim:"<<endl;
			for(i=1; i< this->node_num; i++) {

				if(close[i]->vi !=-1) {
					cout<<this->nodes[close[i]->vi]<<" ";
					cout<<this->nodes[close[i]->vo]<<" ";
					cout<<close[i]->lowcost<<endl;
				}
			}

//			delete [] visit;
//			delete [] e;
		}

		void mergeSet(int set1,int set2,int *node_id) {
			int i,len = sizeof(node_id);
			for(i=0; i<len; i++) {
				if(node_id[i] == set2) {
					node_id[i] = set1;
				}
			}
		}



		void kruskal() {
			int* node_id = new int [this->node_num]();

			CloseE** close = new CloseE*[this->node_num];

			CloseE* e;
			int i,j,num,set_id,min_index,node_num = this->node_num ;
			int sum = 0,visited_num = 1;

			int min = MAX;


			//get edge
			for(i=0,num=0; i<node_num; i++) {
				for(j=i; j<node_num; j++) {
					if(this->mx[i][j]>0) {
						close[num] = new CloseE();
						close[num]->set(i,j,this->mx[i][j]);
						num++;
					}
				}
			}

//			cout<<"num"<<num<<endl;

			//sort small edge
			for(i=0; i<num-1; i++) {
				min_index = i;
				for(j=min_index+1; j<num; j++) {
					if(close[j]->lowcost < close[min_index]->lowcost) {
						min_index = j;
					}
				}

				if(min_index !=i) { //change
					e = new CloseE();
					e->set(close[min_index]->vi,close[min_index]->vo,close[min_index]->lowcost);

					close[min_index]->set(close[i]->vi,close[i]->vo,close[i]->lowcost);
					close[i]->set(e->vi,e->vo,e->lowcost);
				}
			}

			cout<<"kruskal:"<<endl;
			//add edge
			int connected = 0;
			for(i=0,set_id = 1; i< num; i++) {

				if(connected >= this->node_num-1) {
					break;
				}

				int vi = close[i]->vi;
				int vo = close[i]->vo;
				int cost = close[i]->lowcost;

//				cout<<"close: ";
//				cout<< vi <<" "<< vo <<" "<< cost <<endl;
				//join
				if(node_id[vi] == 0 && node_id[vo] == 0) {
					node_id[vi] =  node_id[vo] = set_id;
					set_id++;

					connected++;
					cout<< this->nodes[vi] <<" "<< this->nodes[vo] <<" "<< cost <<endl;

				} else if(node_id[vi] == 0 && node_id[vo] != 0) {
					node_id[vi] = node_id[vo];
					connected++;
					cout<< this->nodes[vi] <<" "<< this->nodes[vo] <<" "<< cost <<endl;

				} else if(node_id[vi] != 0 && node_id[vo] == 0) {
					node_id[vo] = node_id[vi];
					connected++;
					cout<< this->nodes[vi] <<" "<< this->nodes[vo] <<" "<< cost <<endl;

				} else { //both has set
					//not 0
					if(node_id[vi] ==  node_id[vo]) {
						continue; //circle
					}
					//diff set merge
					mergeSet(node_id[vi],node_id[vo],node_id);
					set_id++;
					connected++;
					cout<< this->nodes[vi] <<" "<< this->nodes[vo] <<" "<< cost <<endl;
				}
			}//for i

			//		delete[] e;
//			delete[] node_id;
//			delete[] close;
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
	g->prim(name1);

	g->kruskal();

//	g->~Graph();
//	delete[] nodes;
//	delete[] g;
	return 0;
}
