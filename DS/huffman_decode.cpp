#include <iostream>
#include <string>
#include <cstring>
using namespace std;

#define WT_ARRAY 800
#define OK 1
#define ERROR -1
const int max_w = 9999;

class HuffNode {
	public:
		int weight;
		//index
		int parent;
		int left;
		int right;
		char data;

};


class HuffMan {
	private:
		void init();
		void find2MinNode(int pos,int *node1,int *node2);

	public:
		int node_num;
		int leaf_num;
		HuffNode *huffTree;
		string *huffCode;
		void init(int leaf,int * weight,char* ch);
		void encode();
		int  decode(const string codestr, char* txtstr);
		~HuffMan() {
			node_num = 0;
			leaf_num = 0;
			delete []huffTree;
			delete []huffCode;
		};

};

//public
void HuffMan::init(int leaf,int* weight,char* ch) {
	int i;
	leaf_num = leaf;
	node_num = 2*leaf_num-1;
	huffTree = new HuffNode[2*leaf_num];
	huffCode = new string[leaf_num];

	// set leaf weight
	for(i=1; i<=leaf_num; i++) {
		huffTree[i].weight = weight[i-1];//tree start from 1
		huffTree[i].data = ch[i-1];
	}


	for(i=1; i<=node_num; i++) {

		//set other node weight
		if(i>leaf_num) {
			huffTree[i].weight = 0; //not leaf
			huffTree[i].data = '\0';
		}
		//init node params
		huffTree[i].parent = 0;
		huffTree[i].left = 0;
		huffTree[i].right = 0;
	
	}

	//connect left right
	init();
}

//private
void HuffMan::init() {
	int i,node1,node2;
	for(i=leaf_num; i<node_num; i++) { // not leaf node
		find2MinNode(i,&node1,&node2);
		//node[i-1] is parennt of node1 and node2
	}
}


void HuffMan::find2MinNode(int pos,int *node1,int *node2) {
	int min,min_index = 1,i,t,w1,w2,no_par;

	min = huffTree[min_index].weight;
	//node1
	for(i = min_index+1; i<= pos; i++) {

		if(huffTree[i].weight < min && huffTree[i].parent == 0) {
			min_index = i;
			min = huffTree[i].weight;
		}
	}
	*node1 = min_index;

	//node2
	min_index = (*node1 == 1)? 2:1;

	min = huffTree[min_index].weight;
	
//	cout<<"pos"<<pos<<endl;
//	cout<<"h[pos]->p:"<<huffTree[i].parent<<endl;
	
	no_par = 0;
	for(i = min_index+1; i<= pos; i++) {

		if(i == *node1) {
			continue;
		}

		if(huffTree[i].weight < min && huffTree[i].parent == 0) {
			min_index = i;
			min = huffTree[i].weight;
		}
		
		no_par += (huffTree[i].parent==0)?1:0;//check all no
	}
	
	if(huffTree[min_index].parent!=0 && no_par==1){// all leaf has par and min_index BUT pos no par 
		min_index = pos;
	}
	
	*node2 = min_index;

//	cout<<"node1 "<<*node1<<endl;
//	cout<<"node2 "<<*node2<<endl;
//	cout<<"pos+1 "<<pos+1<<endl;

	//connect leaf right
	huffTree[*node1].parent = pos+1;
	huffTree[*node2].parent = pos+1;

	w1 = huffTree[*node1].weight;
	w2 = huffTree[*node2].weight;

	huffTree[pos+1].left = (w1 <= w2) ? *node1 : *node2;
	huffTree[pos+1].right = (w1 > w2) ? *node1 : *node2;
	huffTree[pos+1].weight = w1+w2;
	
//	cout<<"pa1:"<<huffTree[*node1].parent<<endl;
//	cout<<"pa2:"<<huffTree[*node2].parent<<endl;

}


void HuffMan::encode() {
	int i,j,start,p;
	char *cd;
	cd = new char[leaf_num];

	cd[leaf_num-1]='0';//end

	for(i=1; i<=leaf_num; i++) {
		start = leaf_num-1;

		for(j = i; huffTree[j].parent != 0; start--) {

			p = huffTree[j].parent;
			//	cout<<"h"<<j;
			//	cout<<":"<<huffTree[j].weight<<endl;
			//	cout<<"h[j]-p:"<<p<<endl;
			//	cout<<"huffTree[p].left("<<huffTree[p].left<<") == j("<<j<<")"<<endl;
			cd[start] = (huffTree[p].left == j)? '0':'1';
			j = huffTree[j].parent;
		}

		huffCode[i].assign(&cd[++start]);
//		cout<<"	huffCode[i]:"<<huffCode[i]<<endl;
	}

	delete []cd;

}

int  HuffMan::decode(const string codestr, char* txtstr) {
	int i,k=0,c_len,node_index;
	char ch;
	node_index = node_num;//root
	c_len = codestr.length();


	for(i=0; i<c_len; i++) {
		ch = codestr[i];

		if(ch!='0'&&ch!='1') {
			return ERROR;
		}
		
//		cout<<"node_index"<<node_index<<endl;
		
		node_index = (ch =='0')? huffTree[node_index].left:huffTree[node_index].right;
		
		//END -- turn back to root and add back i 
		if(node_index == 0){
			node_index = node_num;
			i--;
			continue;
		}
		
		
//		cout<<"after: node_index"<<node_index<<endl;
		if(node_index <= leaf_num ) { //leaf
//			cout<<"set txtstr [k]"<<k<<endl;
			
//			cout<<"data"<< huffTree[node_index].data <<endl;
//			cout<<"weight"<< huffTree[node_index].weight <<endl;
			txtstr[k]=huffTree[node_index].data;
			k++;
		} else {
			ch = '\0';
		}

		
	}

	if(ch == '\0') {
		return ERROR;
	} else {
		txtstr[k] = '\0';
		return OK;
	}

}

int main() {

	int t,n,i,j,k,res;
	int* wt;
	char* ch;
	string codestr;
	char* txtstr;
	HuffMan * huff;
	cin>>t;
	while(t--) {
		cin>>n;
//		cout<<"n:"<<n<<endl;
		 
		wt = new int[n];
		ch = new char[n];

		for(i=0; i<n; i++) {
			cin>>wt[i];
		}

		for(i=0; i<n; i++) {
			cin>>ch[i];
		}

		cin>>k;
		
		while(k--) {
			cin>>codestr;
			txtstr = new char[codestr.length()];
			huff = new HuffMan();
			huff->init(n,wt,ch);
			
			res = huff->decode(codestr,txtstr);
			if(res == OK) {
				cout<<txtstr<<endl;
			}else{
				cout<<"error"<<endl;
			}
			
			huff->~HuffMan();
		}
	}


	return 0;
}


