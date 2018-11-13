#include <iostream>
#include <string>
using namespace std;

int getIndex(string * nodes,int node_num,string name);
void echoMx(int **mx,int num) ;
void echoDeg(int **mx,string *nodes,char type);

void echoDeg(int **mx,string *nodes,int num,char type) {
	int i,j,degO,degI;

	for(i=0; i<num; i++) {//each node
		degO = degI = 0;
		cout<<nodes[i];
		//get Deg
		for(j=0; j<num; j++) { //same line each col
			degO += mx[i][j];
			degI += mx[j][i];
		}

		if(degO+degI > 0) {
			cout<<":";
			switch(type) {
				
				case 'D':	//has direction 
					cout<<" "<<degO;
					cout<<" "<<degI;
					cout<<" "<<degO+degI;
					break;
				
				case 'U':	//no direction
					cout<<" "<<degO;
					break;
			}
		}
		cout<<endl;

	}
}

void echoMx(int **mx,int num) {
	int i,j;
	for(i=0; i<num; i++) {
		for(j=0; j<num; j++) {
			if(j != 0) {
				cout<<" ";
			}
			cout<<mx[i][j];
		}
		cout<<endl;
	}
}

int getIndex(string* nodes,int node_num,string name) {
	int i;

	for(i=0; i<node_num; i++) {
		if(nodes[i] == name) {
			return i;
		}
	}
	//not found
	return -1;
}


int main() {
	int i,t,node_num,edge_num,index1,index2;
	int **mx;
	char type;
	string name1,name2;
	string * nodes;

	cin>>t;
	while(t--) {
		cin>>type>>node_num;


		//init mx and nodes
		mx = new int* [node_num];
		nodes = new string [node_num]();
		for(i=0; i<node_num; i++) {
			mx[i] = new int [node_num]();
			cin>>nodes[i];
		}



		cin>>edge_num;

		//use edge to fill mx
		for(i=0; i<edge_num; i++) {

			cin>>name1>>name2;

			index1 = getIndex(nodes,node_num,name1);
			index2 = getIndex(nodes,node_num,name2);

			switch(type) {
					
				case 'U':// no direction ,set symmetry and itself
					mx[index2][index1] = 1;
				
				case 'D'://has direction ,set itself
					mx[index1][index2] = 1;
					break;
			}
		}

		echoMx(mx,node_num);
		echoDeg(mx,nodes,node_num,type);

		delete []mx;
		delete []nodes;
	}//end while

	return 0;
}
